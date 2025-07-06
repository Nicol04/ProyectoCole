<!doctype html>
<html lang="es">
<head>
    @include('panel.includes.head')
    <link rel="stylesheet" href="{{ asset('css/panel/retroalimentacion.css') }}">
</head>

<body>
    <div class="preloader"></div>
    @if (auth()->check())
        @php
            $roleId = auth()->user()->roles->first()?->id;
        @endphp

        @if ($roleId == 3)
            @include('panel.includes.menu_estudiante')
        @elseif($roleId == 2)
            @include('panel.includes.menu_docente')
        @endif
    @endif
    <!--Breadcrumb area start-->
    <div class="text-bread-crumb d-flex align-items-center style-seven">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <h2>Retroalimentación con IA</h2>
                <div class="bread-crumb-line"><span>Pregunta tus dudas docente</span></div>
                </div>
            </div>
        </div>
    </div> 
    <div name="chat">
        <div class="chatgpt-container">
            <div class="chatgpt-header">
                <i class="fas fa-robot"></i> Asistente IA para Docentes
            </div>
            <main class="chatgpt-chat" id="msgerChat"></main>
            <form class="chatgpt-input-area" id="msgerForm" autocomplete="off">
                <div class="chatgpt-input-wrapper">
                    <input type="text" class="chatgpt-input" id="msgerInput" placeholder="Haz cualquier consulta relacionada a tu labor docente..." autocomplete="off">
                    <button type="submit" class="chatgpt-send-btn">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
        <script>
            // Constantes de configuración
            const BOT = {
                IMG: "https://cdn-icons-png.flaticon.com/512/4712/4712035.png",
                NAME: "Asistente"
            };
            const USER = {
                IMG: "https://cdn-icons-png.flaticon.com/512/1946/1946429.png",
                NAME: "Tú"
            };

            // No hay contenido educativo ni tema específico
            const contenidoEducativo = null;

            // Clase para manejar el historial del chat
            class ChatHistory {
                constructor(maxLength = 5) {
                    this.maxLength = maxLength;
                    this.history = [];
                }
                add(role, text) {
                    this.history.push({ rol: role, respuesta: text });
                    if (this.history.length > this.maxLength) this.history.shift();
                }
                getJson() {
                    return [...this.history];
                }
            }

            // Clase para manejar la comunicación con Gemini
            class GeminiAPI {
                constructor(apiKey) {
                    this.url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
                }
                async ask(jsonData) {
                    const body = {
                        contents: [
                            {
                                role: "user",
                                parts: [{
                                    text: JSON.stringify(jsonData, null, 2)
                                }]
                            }
                        ]
                    };
                    const res = await fetch(this.url, {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(body)
                    });
                    return res.json();
                }
                extractAnswer(response) {
                    return response?.candidates?.[0]?.content?.parts?.[0]?.text || 'Sin respuesta de la IA.';
                }
            }

            function formatChatText(text) {
                // Convertir '**palabra**' a <strong>palabra</strong>
                text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

                // Convertir la lista de ítems (con '* **') en un formato con saltos de línea
                text = text.replace(/\* \*\*(.*?)\*\*/g, '<br><strong>$1</strong>');

                return text;
            }

            // Funciones utilitarias para el chat visual
            function appendMessage(name, img, side, text, isNew = false) {
                const bubbleClass = isNew ? "chatgpt-bubble new" : "chatgpt-bubble";
                const rowClass = side === "right" ? "chatgpt-message-row user" : "chatgpt-message-row bot";
                const metaAlign = side === "right" ? "right" : "left";
                const msgHTML = `
                    <div class="${rowClass}">
                        <div class="chatgpt-avatar" style="background-image: url('${img}');"></div>
                        <div>
                            <div class="${bubbleClass}">
                                ${formatChatText(text)}
                            </div>
                            <div class="chatgpt-meta" style="text-align:${metaAlign};">
                                ${name} &middot; ${formatDate(new Date())}
                            </div>
                        </div>
                    </div>
                `;
                msgerChat.insertAdjacentHTML("beforeend", msgHTML);
                msgerChat.scrollTop = msgerChat.scrollHeight;
            }

            function appendLoadingBubble() {
                const loadingHTML = `
                    <div class="chatgpt-message-row bot loading-bubble">
                        <div class="chatgpt-avatar" style="background-image: url('${BOT.IMG}');"></div>
                        <div>
                            <div class="chatgpt-bubble">
                                <div class="loading">
                                    <span class="ball"></span>
                                    <span class="ball"></span>
                                    <span class="ball"></span>
                                </div>
                            </div>
                            <div class="chatgpt-meta" style="text-align:left;">
                                ${BOT.NAME} &middot; ${formatDate(new Date())}
                            </div>
                        </div>
                    </div>
                `;
                msgerChat.insertAdjacentHTML("beforeend", loadingHTML);
                msgerChat.scrollTop = msgerChat.scrollHeight;
            }

            function removeLoadingBubble() {
                const loadingBubble = msgerChat.querySelector('.loading-bubble');
                if (loadingBubble) loadingBubble.remove();
            }

            function formatDate(date) {
                const h = "0" + date.getHours();
                const m = "0" + date.getMinutes();
                return `${h.slice(-2)}:${m.slice(-2)}`;
            }

            // Construye el JSON para el modelo Gemini
            function buildJsonForModel(history) {
                return {
                    historial: history.getJson(),
                    instrucciones: "Eres un asistente de inteligencia artificial especializado en apoyar a docentes. Puedes responder cualquier tipo de consulta relacionada con la labor docente, metodologías, normativas, tecnología educativa, estrategias de aula, evaluación, recursos didácticos, entre otros. Responde de manera clara, profesional y útil.",
                    contenido_educativo: null,
                    mensaje_adicional: "Si la pregunta es muy general, pide más detalles para poder ayudar mejor."
                };
            }

            // Lógica principal del chat
            document.addEventListener("DOMContentLoaded", () => {
                const msgerForm = document.getElementById("msgerForm");
                const msgerInput = document.getElementById("msgerInput");
                window.msgerChat = document.getElementById("msgerChat"); // Para uso en utilidades
                const chatHistory = new ChatHistory(5);
                const gemini = new GeminiAPI('{{ config('services.gemini.api_key') }}');

                msgerForm.addEventListener("submit", async event => {
                    event.preventDefault();
                    const msgText = msgerInput.value.trim();
                    if (!msgText) return;

                    appendMessage(USER.NAME, USER.IMG, "right", msgText, true);
                    chatHistory.add('USUARIO', msgText);
                    msgerInput.value = "";

                    appendLoadingBubble();

                    try {
                        const jsonForModel = buildJsonForModel(chatHistory);
                        const response = await gemini.ask(jsonForModel);
                        const answer = gemini.extractAnswer(response);
                        removeLoadingBubble();
                        appendMessage(BOT.NAME, BOT.IMG, "left", answer, true);
                        chatHistory.add('MODELO', answer);
                    } catch {
                        removeLoadingBubble();
                        appendMessage(BOT.NAME, BOT.IMG, "left", "Error al conectar con la IA.", true);
                    }
                });
            });
        </script>
    </div>
    

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>