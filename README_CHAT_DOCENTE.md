# Documentación del Sistema de Chat IA para Docentes

## Descripción General
Este documento describe el funcionamiento del sistema de chat con inteligencia artificial especializado para docentes, implementado en la vista `retroalimentacion.blade.php`. El sistema permite a los docentes hacer consultas sobre metodologías, normativas, tecnología educativa y cualquier aspecto relacionado con la labor docente.

## Estructura del Archivo

### 1. Estructura HTML Completa

#### Encabezado y Meta
```html
<!doctype html>
<html lang="es">
<head>
    @include('panel.includes.head')
    <link rel="stylesheet" href="{{ asset('css/panel/retroalimentacion.css') }}">
</head>
```
- **DOCTYPE**: HTML5 estándar
- **Idioma**: Español (`lang="es"`)
- **Includes**: Head común del panel
- **CSS específico**: `retroalimentacion.css` para estilos del chat

#### Body y Navegación
```html
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
```
- **Preloader**: Indicador de carga inicial
- **Autenticación**: Verifica si el usuario está autenticado
- **Menú dinámico**:
  - Role ID 3: Menú de estudiante
  - Role ID 2: Menú de docente

#### Breadcrumb
```html
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
```
- **Título principal**: "Retroalimentación con IA"
- **Subtítulo**: "Pregunta tus dudas docente"
- **Clases Bootstrap**: Para layout responsivo

### 2. Interfaz del Chat

#### Contenedor Principal
```html
<div name="chat">
    <div class="chatgpt-container">
```
- **Contenedor externo**: `name="chat"` para identificación
- **Contenedor principal**: Estilo similar a ChatGPT

#### Encabezado del Chat
```html
<div class="chatgpt-header">
    <i class="fas fa-robot"></i> Asistente IA para Docentes
</div>
```
- **Ícono**: Robot de Font Awesome
- **Título**: Identifica el propósito específico del chat

#### Área de Mensajes
```html
<main class="chatgpt-chat" id="msgerChat"></main>
```
- **Tag semántico**: `<main>` para contenido principal
- **ID único**: `msgerChat` para manipulación JavaScript
- **Contenido dinámico**: Se llena via JavaScript

#### Formulario de Entrada
```html
<form class="chatgpt-input-area" id="msgerForm" autocomplete="off">
    <div class="chatgpt-input-wrapper">
        <input type="text" class="chatgpt-input" id="msgerInput" 
               placeholder="Haz cualquier consulta relacionada a tu labor docente..." 
               autocomplete="off">
        <button type="submit" class="chatgpt-send-btn">
            <i class="fa fa-paper-plane"></i>
        </button>
    </div>
</form>
```
- **Placeholder específico**: Guía para consultas docentes
- **Autocomplete deshabilitado**: Evita sugerencias
- **Botón con ícono**: Avión de papel para enviar

## 3. Código JavaScript

### Constantes de Configuración

#### Participantes del Chat
```javascript
const BOT = {
    IMG: "https://cdn-icons-png.flaticon.com/512/4712/4712035.png",
    NAME: "Asistente"
};
const USER = {
    IMG: "https://cdn-icons-png.flaticon.com/512/1946/1946429.png",
    NAME: "Tú"
};
```
- **BOT**: Avatar del robot asistente
- **USER**: Avatar genérico del usuario

#### Variable de Contenido
```javascript
const contenidoEducativo = null;
```
- **Propósito**: Indica que no hay contenido específico
- **Diferencia**: Con el chat de estudiantes que puede tener contenido de evaluaciones

### Clases Principales

#### Clase `ChatHistory`
```javascript
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
```
- **Propósito**: Mantiene contexto de conversación
- **Límite**: 5 mensajes máximo para optimizar rendimiento
- **Estructura**: Array de objetos con `rol` y `respuesta`
- **Métodos**:
  - `add()`: Agrega mensaje y mantiene límite
  - `getJson()`: Retorna copia del historial

#### Clase `GeminiAPI`
```javascript
class GeminiAPI {
    constructor(apiKey) {
        this.url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
    }
    async ask(jsonData) {
        const body = {
            contents: [{
                role: "user",
                parts: [{ text: JSON.stringify(jsonData, null, 2) }]
            }]
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
```
- **URL**: Endpoint de Gemini 2.0 Flash
- **Método `ask()`**: Envía petición POST con datos JSON
- **Método `extractAnswer()`**: Extrae texto de respuesta con fallback

### Funciones Utilitarias

#### `formatChatText(text)`
```javascript
function formatChatText(text) {
    // Convertir '**palabra**' a <strong>palabra</strong>
    text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    
    // Convertir la lista de ítems (con '* **') en un formato con saltos de línea
    text = text.replace(/\* \*\*(.*?)\*\*/g, '<br><strong>$1</strong>');
    
    return text;
}
```
- **Propósito**: Convierte markdown básico a HTML
- **Transformaciones**:
  - Texto en negrita: `**texto**` → `<strong>texto</strong>`
  - Listas con negrita: `* **texto**` → `<br><strong>texto</strong>`

#### `appendMessage(name, img, side, text, isNew)`
```javascript
function appendMessage(name, img, side, text, isNew = false) {
    const bubbleClass = isNew ? "chatgpt-bubble new" : "chatgpt-bubble";
    const rowClass = side === "right" ? "chatgpt-message-row user" : "chatgpt-message-row bot";
    const metaAlign = side === "right" ? "right" : "left";
    const msgHTML = `...`;
    msgerChat.insertAdjacentHTML("beforeend", msgHTML);
    msgerChat.scrollTop = msgerChat.scrollHeight;
}
```
- **Parámetros**:
  - `name`: Nombre del remitente
  - `img`: URL del avatar
  - `side`: "right" (usuario) o "left" (bot)
  - `text`: Contenido del mensaje
  - `isNew`: Aplica animación de nuevo mensaje
- **Funcionalidades**:
  - Diferentes clases CSS según remitente
  - Alineación dinámica de metadatos
  - Auto-scroll al último mensaje

#### `appendLoadingBubble()` y `removeLoadingBubble()`
```javascript
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
```
- **Propósito**: Muestra indicador de "escribiendo"
- **Animación**: Tres puntos animados
- **Clase especial**: `loading-bubble` para fácil remoción

#### `formatDate(date)`
```javascript
function formatDate(date) {
    const h = "0" + date.getHours();
    const m = "0" + date.getMinutes();
    return `${h.slice(-2)}:${m.slice(-2)}`;
}
```
- **Formato**: HH:MM (24 horas)
- **Padding**: Agrega ceros a la izquierda si es necesario

### Función de Configuración Principal

#### `buildJsonForModel(history)`
```javascript
function buildJsonForModel(history) {
    return {
        historial: history.getJson(),
        instrucciones: "Eres un asistente de inteligencia artificial especializado en apoyar a docentes. Puedes responder cualquier tipo de consulta relacionada con la labor docente, metodologías, normativas, tecnología educativa, estrategias de aula, evaluación, recursos didácticos, entre otros. Responde de manera clara, profesional y útil.",
        contenido_educativo: null,
        mensaje_adicional: "Si la pregunta es muy general, pide más detalles para poder ayudar mejor."
    };
}
```
- **Especialización**: Instrucciones específicas para consultas docentes
- **Áreas de apoyo**:
  - Metodologías de enseñanza
  - Normativas educativas
  - Tecnología educativa
  - Estrategias de aula
  - Evaluación
  - Recursos didácticos
- **Comportamiento**: Solicita detalles para preguntas generales

## 4. Lógica Principal del Chat

### Inicialización
```javascript
document.addEventListener("DOMContentLoaded", () => {
    const msgerForm = document.getElementById("msgerForm");
    const msgerInput = document.getElementById("msgerInput");
    window.msgerChat = document.getElementById("msgerChat");
    const chatHistory = new ChatHistory(5);
    const gemini = new GeminiAPI('{{ config('services.gemini.api_key') }}');
    
    // Event listener para envío de mensajes
});
```
- **Event listener**: Espera a que DOM esté cargado
- **Referencias**: Obtiene elementos del formulario
- **Instancias**: Crea historial y cliente API
- **API Key**: Obtenida desde configuración Laravel

### Flujo de Envío de Mensajes
```javascript
msgerForm.addEventListener("submit", async event => {
    event.preventDefault();
    const msgText = msgerInput.value.trim();
    if (!msgText) return;

    // 1. Mostrar mensaje del usuario
    appendMessage(USER.NAME, USER.IMG, "right", msgText, true);
    chatHistory.add('USUARIO', msgText);
    msgerInput.value = "";

    // 2. Mostrar indicador de carga
    appendLoadingBubble();

    try {
        // 3. Enviar a IA y procesar respuesta
        const jsonForModel = buildJsonForModel(chatHistory);
        const response = await gemini.ask(jsonForModel);
        const answer = gemini.extractAnswer(response);
        
        // 4. Mostrar respuesta
        removeLoadingBubble();
        appendMessage(BOT.NAME, BOT.IMG, "left", answer, true);
        chatHistory.add('MODELO', answer);
    } catch {
        // 5. Manejo de errores
        removeLoadingBubble();
        appendMessage(BOT.NAME, BOT.IMG, "left", "Error al conectar con la IA.", true);
    }
});
```

## 5. Flujo Completo de Funcionamiento

### 1. Carga de Página
1. Se carga el HTML con preloader
2. Se verifica autenticación del usuario
3. Se muestra menú según rol (docente/estudiante)
4. Se inicializa el chat cuando DOM está listo

### 2. Inicialización del Chat
1. Se obtienen referencias a elementos HTML
2. Se crean instancias de `ChatHistory` y `GeminiAPI`
3. Se configura event listener para envío de formulario

### 3. Envío de Mensaje
1. **Validación**: Se verifica que el mensaje no esté vacío
2. **Visualización**: Se muestra mensaje del usuario en el chat
3. **Historial**: Se agrega mensaje al historial de conversación
4. **UI**: Se limpia el input y se muestra indicador de carga

### 4. Procesamiento IA
1. **Preparación**: Se construye JSON con historial e instrucciones
2. **Envío**: Se hace petición POST a API de Gemini
3. **Procesamiento**: Se espera respuesta asíncrona

### 5. Mostrar Respuesta
1. **Extracción**: Se extrae texto de la respuesta JSON
2. **Visualización**: Se remueve carga y se muestra respuesta
3. **Historial**: Se agrega respuesta al historial
4. **UI**: El chat queda listo para siguiente interacción

### 6. Manejo de Errores
1. **Captura**: Try-catch captura errores de red o API
2. **UI**: Se remueve indicador de carga
3. **Feedback**: Se muestra mensaje de error al usuario

## 6. Diferencias con el Chat de Estudiantes

### Especialización de Contenido
- **Docentes**: Consultas sobre metodología, normativas, etc.
- **Estudiantes**: Ayuda con contenido educativo específico

### Instrucciones de IA
- **Docentes**: Enfoque profesional y técnico
- **Estudiantes**: Lenguaje simple adaptado a la edad

### Contexto de Uso
- **Docentes**: Sin restricciones de supervisión
- **Estudiantes**: Puede tener modo supervisado/no supervisado

### Interfaz
- **Docentes**: Estilo "ChatGPT" más profesional
- **Estudiantes**: Interfaz más lúdica y colorida

## 7. Dependencias y Configuración

### Dependencias Externas
- **API de Gemini**: Google Generative AI
- **Font Awesome**: Íconos (`fas fa-robot`, `fa fa-paper-plane`)
- **Bootstrap**: Grid system y utilidades CSS

### Dependencias Internas
- **Laravel Auth**: Sistema de autenticación
- **Blade Includes**: Componentes reutilizables del panel
- **CSS personalizado**: `retroalimentacion.css`

### Configuración Laravel
```php
config('services.gemini.api_key')
```
- Definida en `config/services.php`
- Obtiene valor de variable de entorno `GEMINI_API_KEY`

## 8. Consideraciones Técnicas

### Seguridad
- API key protegida en configuración servidor
- No exposición de datos sensibles en frontend
- Validación básica de entrada

### Performance
- Historial limitado a 5 mensajes
- Carga asíncrona de respuestas
- Indicadores visuales para mejor UX

### Accesibilidad
- Elementos semánticos HTML5
- Placeholders descriptivos
- Controles de teclado estándar

### Escalabilidad
- Código modular y reutilizable
- Clases JavaScript bien estructuradas
- Fácil mantenimiento y extensión
