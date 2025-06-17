<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        :root {
            --primary-bg: #f7f7f8;
            --chat-bg: #fff;
            --border: 1.5px solid #ececf1;
            --user-bg: #10a37f;
            --user-text: #fff;
            --bot-bg: #ececf1;
            --bot-text: #222;
            --avatar-size: 40px;
            --bubble-radius: 18px;
            --header-bg: #fff;
            --header-color: #222;
            --input-bg: #fff;
            --input-radius: 16px;
            --send-btn-bg: #10a37f;
            --send-btn-bg-hover: #0d8a6b;
            --shadow: 0 4px 32px rgba(0,0,0,0.07);
        }

        body {
            min-height: 100vh;
            background: var(--primary-bg);
            font-family: 'Inter', Helvetica, Arial, sans-serif;
        }

        .chatgpt-container {
            display: flex;
            flex-direction: column;
            height: 90vh;
            min-height: 500px;
            width: 100vw;
            max-width: 100vw;
            margin: 0;
            background: var(--primary-bg);
        }

        .chatgpt-header {
            background: var(--header-bg);
            color: var(--header-color);
            padding: 24px 0 16px 0;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            border-bottom: var(--border);
            letter-spacing: 0.5px;
            box-shadow: var(--shadow);
        }

        .chatgpt-header i {
            color: #10a37f;
            margin-right: 10px;
        }

        .chatgpt-chat {
            flex: 1;
            overflow-y: auto;
            padding: 32px 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
            width: 100%;
        }

        .chatgpt-message-row {
            display: flex;
            align-items: flex-start;
            width: 100%;
            max-width: 820px;
            margin: 0 auto;
            padding: 0 16px;
        }

        .chatgpt-message-row.user {
            flex-direction: row-reverse;
        }

        .chatgpt-avatar {
            width: var(--avatar-size);
            height: var(--avatar-size);
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            margin: 0 12px;
            flex-shrink: 0;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        }

        .chatgpt-bubble {
            max-width: 80vw;
            padding: 18px 22px;
            border-radius: var(--bubble-radius);
            font-size: 1.08rem;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.06);
            word-break: break-word;
            border: none;
            margin-bottom: 2px;
        }

        .chatgpt-message-row.user .chatgpt-bubble {
            background: var(--user-bg);
            color: var(--user-text);
            border-bottom-right-radius: 6px;
            border-bottom-left-radius: var(--bubble-radius);
        }

        .chatgpt-message-row.bot .chatgpt-bubble {
            background: var(--bot-bg);
            color: var(--bot-text);
            border-bottom-left-radius: 6px;
            border-bottom-right-radius: var(--bubble-radius);
        }

        .chatgpt-meta {
            font-size: 0.85em;
            color: #888;
            margin: 2px 0 0 0;
            text-align: left;
        }

        .chatgpt-message-row.user .chatgpt-meta {
            text-align: right;
        }

        .chatgpt-input-area {
            background: var(--input-bg);
            border-top: var(--border);
            padding: 18px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 -2px 8px rgba(44, 62, 80, 0.03);
        }

        .chatgpt-input-wrapper {
            display: flex;
            width: 100%;
            max-width: 820px;
            gap: 12px;
            padding: 0 16px;
        }

        .chatgpt-input {
            flex: 1;
            padding: 14px 18px;
            border: 1.5px solid #ececf1;
            border-radius: var(--input-radius);
            background: var(--input-bg);
            font-size: 1.08rem;
            outline: none;
            transition: box-shadow 0.2s;
            box-shadow: 0 1px 2px rgba(44, 62, 80, 0.04);
        }

        .chatgpt-input:focus {
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.09);
            border-color: #10a37f;
        }

        .chatgpt-send-btn {
            padding: 0 28px;
            background: var(--send-btn-bg);
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.08rem;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.09);
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chatgpt-send-btn:hover {
            background: var(--send-btn-bg-hover);
        }

        .chatgpt-bubble.new {
            animation: bounce 0.7s cubic-bezier(.68, -0.55, .27, 1.55);
            transform-origin: bottom left;
        }

        @keyframes bounce {
            0% { transform: scale(0.2); opacity: 0.2; }
            60% { transform: scale(1.1); opacity: 1; }
            80% { transform: scale(0.95);}
            100% { transform: scale(1); opacity: 1;}
        }

        .loading {
            display: flex;
            align-items: center;
            height: 32px;
            margin: 8px 0;
        }
        .loading .ball {
            width: 9px;
            height: 9px;
            background: #10a37f;
            border-radius: 50%;
            margin: 0 3px;
            display: inline-block;
            animation: ball 0.7s infinite alternate;
        }
        .loading .ball:nth-child(2) { animation-delay: 0.15s; }
        .loading .ball:nth-child(3) { animation-delay: 0.3s; }
        @keyframes ball {
            0% { transform: translateY(0); opacity: 0.7; }
            100% { transform: translateY(-12px); opacity: 1; }
        }

        @media (max-width: 900px) {
            .chatgpt-container { height: 95vh; }
            .chatgpt-chat { padding: 16px 0; }
            .chatgpt-message-row { padding: 0 4vw; }
            .chatgpt-input-wrapper { padding: 0 4vw; }
        }
        @media (max-width: 600px) {
            .chatgpt-header { font-size: 1.1rem; padding: 16px 0 10px 0; }
            .chatgpt-message-row { padding: 0 2vw; }
            .chatgpt-input-wrapper { padding: 0 2vw; }
            .chatgpt-bubble { font-size: 0.98rem; padding: 12px 10px; }
            .chatgpt-avatar { width: 32px; height: 32px; }
        }
    </style>
</head>

<body>
    <div class="preloader"></div>
    <div class="preloader"></div> <!-- carga -->
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
                const gemini = new GeminiAPI('AIzaSyCM1ERzhhDdON5dWNUXbO4MNWgHZqDFp4E');

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