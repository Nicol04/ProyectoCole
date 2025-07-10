# Documentación del Sistema de Chat con IA

## Descripción General
Este documento describe el funcionamiento del sistema de chat con inteligencia artificial implementado en la vista `chat.blade.php`. El sistema permite a los estudiantes interactuar con un asistente educativo basado en la API de Gemini de Google.

## Estructura del Archivo

### 1. Estructura HTML

#### Botón Flotante
```html
<button id="chatOpenBtn" class="chat-open-btn" style="display:none;" title="Abrir chat">
    💬
</button>
```
- **Propósito**: Botón que aparece cuando el chat está minimizado
- **Estado inicial**: Oculto (`display:none`)
- **Función**: Permite reabrir el chat después de cerrarlo

#### Ventana Principal del Chat
```html
<section class="msger draggable-chat" id="draggableChat">
```
- **Clase `msger`**: Contenedor principal del chat
- **Clase `draggable-chat`**: Permite arrastrar la ventana
- **ID `draggableChat`**: Referencia para la funcionalidad de arrastre

#### Encabezado del Chat
- **Logo**: Muestra el logo del colegio (200px de ancho)
- **Botón de configuración**: Ícono de engranaje (actualmente no funcional)
- **Botón de cerrar**: Permite minimizar el chat

#### Área de Mensajes
```html
<main class="msger-chat" id="msgerChat"></main>
```
- **Propósito**: Contenedor donde se muestran todos los mensajes
- **Contenido dinámico**: Se llena mediante JavaScript

#### Formulario de Entrada
```html
<form class="msger-inputarea" id="msgerForm" autocomplete="off">
```
- **Input de texto**: Para escribir mensajes
- **Botón de envío**: Para enviar mensajes
- **Autocomplete deshabilitado**: Evita sugerencias del navegador

### 2. Variables PHP

#### Variable de Supervisión
```php
@php
    $esSupervisado = $evaluacion->es_supervisado ?? 0;
@endphp
```
- **Propósito**: Determina si la evaluación está siendo supervisada por un docente
- **Valores**: 
  - `1`: Supervisado (respuestas más cortas y directas)
  - `0`: No supervisado (explicaciones más detalladas)
- **Fuente**: Campo `es_supervisado` del modelo `Evaluacion`

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
- **BOT**: Configuración del asistente IA (avatar e nombre)
- **USER**: Configuración del usuario (avatar e nombre)

### Clases Principales

#### Clase `ChatHistory`
```javascript
class ChatHistory {
    constructor(maxLength = 5)
    add(role, text)
    getJson()
}
```
- **Propósito**: Gestiona el historial de conversación para mantener contexto
- **Límite**: Máximo 5 mensajes (configurable)
- **Métodos**:
  - `add()`: Agrega nuevo mensaje al historial
  - `getJson()`: Retorna historial en formato JSON para la IA

#### Clase `GeminiAPI`
```javascript
class GeminiAPI {
    constructor(apiKey)
    async ask(jsonData)
    extractAnswer(response)
}
```
- **Propósito**: Maneja la comunicación con la API de Gemini
- **URL**: `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent`
- **Métodos**:
  - `ask()`: Envía petición a la API
  - `extractAnswer()`: Extrae respuesta del objeto de respuesta

### Funciones Utilitarias

#### `formatChatText(text)`
- **Propósito**: Convierte markdown básico a HTML
- **Conversiones**:
  - `**texto**` → `<strong>texto</strong>`
  - `* **texto**` → `<br><strong>texto</strong>`

#### `appendMessage(name, img, side, text, isNew)`
- **Propósito**: Agrega mensaje visual al chat
- **Parámetros**:
  - `name`: Nombre del remitente
  - `img`: URL del avatar
  - `side`: "left" (IA) o "right" (usuario)
  - `text`: Contenido del mensaje
  - `isNew`: Aplica animación de nuevo mensaje

#### `appendLoadingBubble()` / `removeLoadingBubble()`
- **Propósito**: Muestra/oculta indicador de carga
- **Animación**: Tres puntos animados mientras la IA procesa

#### `formatDate(date)`
- **Propósito**: Formatea fecha para mostrar en mensajes
- **Formato**: HH:MM (24 horas)

#### `buildJsonForModel(history)`
- **Propósito**: Construye objeto JSON para enviar a la IA
- **Incluye**:
  - Historial de conversación
  - Instrucciones específicas según supervisión
  - Nombre del usuario autenticado
  - Mensaje adicional con contexto

### Funcionalidades Especiales

#### Sistema de Arrastre
```javascript
(function enableDragAndDrop() {
    // Funcionalidad de drag & drop
})();
```
- **Activación**: Solo cuando se hace clic en el encabezado
- **Límites**: Mantiene el chat dentro de los límites de la ventana
- **Estados**: Agrega clase `dragging` durante el arrastre

#### Lógica Principal del Chat
- **Event listener**: Maneja envío de formulario
- **Flujo**:
  1. Captura mensaje del usuario
  2. Muestra mensaje en el chat
  3. Agrega al historial
  4. Muestra indicador de carga
  5. Envía a API de Gemini
  6. Muestra respuesta de la IA
  7. Agrega respuesta al historial

#### Control de Visibilidad
- **Estado inicial**: Chat visible, botón flotante oculto
- **Función `showChat()`**: Muestra chat, oculta botón
- **Función `hideChat()`**: Oculta chat, muestra botón

## 4. Configuración de la IA

### Modo Supervisado (`es_supervisado = 1`)
```
"Eres un asistente educativo para niños de aproximadamente 10 años. 
El docente está presente, así que responde de manera corta, sencilla y directa. 
Usa ejemplos fáciles y evita explicaciones largas."
```

### Modo No Supervisado (`es_supervisado = 0`)
```
"Eres un asistente educativo para niños de aproximadamente 10 años. 
Te haré una pregunta que tu deberás responder ubicando fuentes confiables 
y dando una explicación."
```

## 5. Dependencias

### Externas
- **API de Gemini**: Servicio de IA de Google
- **Font Awesome**: Para íconos (`fas fa-cog`)
- **CSS personalizado**: `css/panel/chat.css`

### Internas
- **Laravel Auth**: Para obtener datos del usuario autenticado
- **Modelo Evaluacion**: Para obtener estado de supervisión
- **Configuración Laravel**: `config('services.gemini.api_key')`

## 6. Flujo de Funcionamiento

1. **Inicialización**:
   - Se cargan las constantes y se crean instancias de las clases
   - Se configuran los event listeners
   - Se muestra el chat por defecto

2. **Envío de Mensaje**:
   - Usuario escribe y envía mensaje
   - Se muestra mensaje en pantalla
   - Se agrega al historial
   - Se muestra indicador de carga

3. **Procesamiento IA**:
   - Se construye JSON con historial e instrucciones
   - Se envía a API de Gemini
   - Se recibe y procesa respuesta

4. **Mostrar Respuesta**:
   - Se remueve indicador de carga
   - Se muestra respuesta de la IA
   - Se agrega respuesta al historial

5. **Gestión de Contexto**:
   - El historial mantiene contexto de conversación
   - Se limita a 5 mensajes para optimizar rendimiento
   - Cada nueva interacción tiene acceso al contexto previo

## 7. Consideraciones Técnicas

### Seguridad
- La API key se obtiene desde configuración de Laravel
- No se expone información sensible en el frontend

### Performance
- Historial limitado a 5 mensajes para reducir payload
- Carga asíncrona de respuestas
- Indicadores visuales para mejorar UX

### Responsividad
- Chat arrastreable para mejor usabilidad
- Botón flotante para acceso rápido
- Auto-scroll en área de mensajes

### Accesibilidad
- Tooltips en botones
- Placeholders descriptivos
- Controles de teclado (Enter para enviar)
