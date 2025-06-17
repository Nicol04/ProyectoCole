<link rel="stylesheet" href="{{ asset('css/panel/chat.css') }}">


<!-- Botón flotante para abrir el chat -->
<button id="chatOpenBtn" class="chat-open-btn" style="display:none;" title="Abrir chat">
    💬
</button>

<section class="msger draggable-chat" id="draggableChat">
    <header class="msger-header">
        <div class="msger-header-title">
            <img src="{{ asset('assets/img/panel/logo.png') }}" alt="" width="200">
        </div>
        <div class="msger-header-options d-flex align-items-center">
            <span><i class="fas fa-cog"></i></span>
            <button type="button" class="msger-close-btn" id="msgerCloseBtn" title="Cerrar chat">&times;</button>
        </div>
    </header>
    <main class="msger-chat" id="msgerChat"></main>
    <form class="msger-inputarea" id="msgerForm" autocomplete="off">
        <input type="text" class="msger-input" id="msgerInput" placeholder="Escribe tu mensaje..."
            autocomplete="off">
        <button type="submit" class="msger-send-btn">Enviar</button>
    </form>
</section>

@php
    $esSupervisado = $evaluacion->es_supervisado ?? 0;
@endphp

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


    // Clase para manejar el historial del chat
    class ChatHistory {
        constructor(maxLength = 5) {
            this.maxLength = maxLength;
            this.history = [];
        }
        add(role, text) {
            this.history.push({
                rol: role,
                respuesta: text
            });
            if (this.history.length > this.maxLength) this.history.shift();
        }
        getJson() {
            return [...this.history];
        }
    }

    // Clase para manejar la comunicación con Gemini
    class GeminiAPI {
        constructor(apiKey) {
            this.url =
                `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
        }
        async ask(jsonData) {
            const body = {
                contents: [{
                    role: "user",
                    parts: [{
                        text: JSON.stringify(jsonData, null, 2)
                    }]
                }]
            };
            const res = await fetch(this.url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
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
        const bubbleClass = isNew ? "msg-bubble new" : "msg-bubble";
        const msgHTML = `
                <div class="msg ${side}-msg">
                    <div class="msg-img" style="background-image: url('${img}');"></div>
                    <div class="${bubbleClass}">
                        <div class="msg-info">
                            <div class="msg-info-name">${name}</div>
                            <div class="msg-info-time">${formatDate(new Date())}</div>
                        </div>
                        <div class="msg-text">${formatChatText(text)}</div>
                    </div>
                </div>
            `;
        msgerChat.insertAdjacentHTML("beforeend", msgHTML);
        msgerChat.scrollTop = msgerChat.scrollHeight;
    }

    function appendLoadingBubble() {
        const loadingHTML = `
                <div class="msg left-msg loading-bubble">
                    <div class="msg-img" style="background-image: url('${BOT.IMG}');"></div>
                    <div class="msg-bubble">
                        <div class="msg-info">
                            <div class="msg-info-name">${BOT.NAME}</div>
                            <div class="msg-info-time">${formatDate(new Date())}</div>
                        </div>
                        <div class="msg-text">
                            <div class="loading">
                                <span class="ball"></span>
                                <span class="ball"></span>
                                <span class="ball"></span>
                            </div>
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

    function buildJsonForModel(history) {
        // Toma el nombre del usuario autenticado de FilamentPHP (Laravel Auth)
        const authName = @json(auth()->user()->persona->nombre ?? 'Usuario');
        const esSupervisado = @json($esSupervisado);
        
        let instrucciones = "";
                
        if (esSupervisado == 1) {
            instrucciones = "Eres un asistente educativo para niños de aproximadamente 10 años. El docente está presente, así que responde de manera corta, sencilla y directa. Usa ejemplos fáciles y evita explicaciones largas. Recibirás un historial de la conversación en formato JSON, donde cada elemento tiene un 'rol' (USUARIO o MODELO) y una 'respuesta'. Responde solo a la última pregunta del usuario.";
        }else{
            instrucciones = "Eres un asistente educativo para niños de aproximadamente 10 años. Te hare una pregunta que tu deberas responder ubicando fuentes confiables y dando una explicación. Recibirás un historial de la conversación en formato JSON, donde cada elemento tiene un 'rol' (USUARIO o MODELO) y una 'respuesta'. Usa este historial para entender el contexto y responder de manera coherente y relevante a la última pregunta del usuario. Responde solo a la última pregunta del usuario.";
        }

        return {
            historial: history.getJson(),
            instrucciones: instrucciones,
            mensaje_adicional: `Mi nombre es ${authName}. Recuerda, la respuesta debe ser clara, comprensible, usando ejemplos que sean fáciles de entender.`
        };
    }


    // Drag & Drop para el chat
    (function enableDragAndDrop() {
        const chat = document.getElementById('draggableChat');
        let isDragging = false,
            offsetX = 0,
            offsetY = 0;
        chat.addEventListener('mousedown', function(e) {
            if (!e.target.closest('.msger-header')) return;
            isDragging = true;
            chat.classList.add('dragging');
            offsetX = e.clientX - chat.getBoundingClientRect().left;
            offsetY = e.clientY - chat.getBoundingClientRect().top;
            document.body.style.userSelect = 'none';
        });
        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            let x = e.clientX - offsetX;
            let y = e.clientY - offsetY;
            x = Math.max(0, Math.min(window.innerWidth - chat.offsetWidth, x));
            y = Math.max(0, Math.min(window.innerHeight - chat.offsetHeight, y));
            chat.style.left = x + 'px';
            chat.style.top = y + 'px';
            chat.style.right = 'auto';
            chat.style.bottom = 'auto';
        });
        document.addEventListener('mouseup', function() {
            if (isDragging) {
                isDragging = false;
                chat.classList.remove('dragging');
                document.body.style.userSelect = '';
            }
        });
    })();

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

    // Mostrar/ocultar chat y botón flotante
    document.addEventListener("DOMContentLoaded", function() {
        const chatSection = document.getElementById('draggableChat');
        const openBtn = document.getElementById('chatOpenBtn');
        const closeBtn = document.getElementById('msgerCloseBtn');

        function showChat() {
            chatSection.style.display = '';
            openBtn.style.display = 'none';
        }
        function hideChat() {
            chatSection.style.display = 'none';
            openBtn.style.display = '';
        }

        // Inicialmente mostrar el chat y ocultar el botón flotante
        showChat();

        closeBtn.addEventListener('click', hideChat);
        openBtn.addEventListener('click', showChat);
    });
</script>
