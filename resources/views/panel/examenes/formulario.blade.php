<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>

    <div class="admission-process-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center mb-4">
                    <h1 class="area-heading font-per style-two">Generador de Examenes</h1>
                    <p class="heading-para">Seleccione el modo para generar las preguntas y complete los campos.</p>
                </div>
            </div>

            <!-- Selector de modo de entrada -->
            <div class="row justify-content-center mb-4">
                <div class="col-xl-6">
                    <label class="form-label fw-semibold">¿Cómo deseas generar las preguntas?</label>
                    <select id="modoEntrada" class="form-select w-100" onchange="cambiarModoEntrada()">
                        <option value="imagen" selected>Subir Imagen</option>
                        <option value="texto">Escribir Texto</option>
                    </select>
                </div>
            </div>

            <!-- Entrada para subir imagen -->
            <div id="entradaImagen" class="row justify-content-center mb-4">
                <div class="col-xl-6">
                    <label class="form-label text-secondary">Selecciona una imagen para analizar</label>
                    <input type="file" id="imagen" accept="image/*" capture="environment"
                        class="form-control form-control-sm" />
                </div>
            </div>
            <!-- Contenedor de vista previa -->
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div id="archivo-preview" class="text-center mt-3"></div>
                </div>
            </div>
            <div id="entradaTexto" class="row justify-content-center mb-4" style="display: none;">
                <div class="col-xl-6">
                    <label for="textoFuente" class="form-label text-secondary">Escribe el texto para generar
                        preguntas</label>
                    <textarea id="textoFuente" rows="5" class="form-control form-control-sm" placeholder="Escribe aquí el texto..."></textarea>
                </div>
            </div>
            <input type="hidden" id="numPreguntas" value="{{ $cantidad_preguntas }}">
            <div class="row justify-content-center mb-4">
                <div class="col-xl-4 d-flex justify-content-center">
                    <button id="botonEnviar" onclick="enviarEntrada()"
                        class="btn btn-primary d-flex align-items-center gap-2 py-2 px-4 rounded text-white">
                        <span id="textoBoton">Enviar Imagen</span>
                        <span id="spinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <main class="container w-75 mx-auto gy-4">
        <section class="formulario-ia bg-white border border-secondary p-4 rounded-3 shadow-lg gy-3">
            

            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-secondary">📄 Estado del examen:</label>
                <div id="mensajeExamen" class="alert d-none"></div>
            </div>

            <section id="contenedorFormulario" class="gy-3"></section>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('imagen').addEventListener('change', function(e) {
                const preview = document.getElementById('archivo-preview');
                const file = e.target.files[0];

                preview.innerHTML = ''; // Limpiar contenido previo
                if (!file) return;
                const fileType = file.type;
                if (fileType.startsWith('image/')) {
                    // Si es imagen
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML =
                            `<img src="${e.target.result}" alt="Vista previa" style="max-width: 100%; max-height: 400px;" class="img-fluid rounded shadow">`;
                    };
                    reader.readAsDataURL(file);
                } else if (fileType === 'application/pdf') {
                    // Si es PDF
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML =
                            `<embed src="${e.target.result}" type="application/pdf" width="100%" height="400px">`;
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML =
                        '<p class="text-danger">No se puede previsualizar este tipo de archivo.</p>';
                }
            });
        });

        function cambiarModoEntrada() {
            const modo = document.getElementById('modoEntrada').value;
            document.getElementById('entradaImagen').style.display = modo === 'imagen' ? '' : 'none';
            document.getElementById('entradaTexto').style.display = modo === 'texto' ? '' : 'none';
            // Cambia el texto del botón según el modo
            document.getElementById('textoBoton').textContent = modo === 'imagen' ? "Enviar Imagen" : "Enviar Texto";
        }

        function mostrarSpinner(mostrar) {
            document.getElementById('spinner').classList.toggle('d-none', !mostrar);
            const modo = document.getElementById('modoEntrada').value;
            document.getElementById('textoBoton').textContent = mostrar ?
                "Procesando..." :
                (modo === 'imagen' ? "Enviar Imagen" : "Enviar Texto");
        }

        function convertirABase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = () => resolve(reader.result);
                reader.onerror = error => reject(error);
                reader.readAsDataURL(file);
            });
        }

        function construirPrompt(numPreguntas, texto = '') {
            return `**Devuelve únicamente el array JSON** con la estructura exacta: 
        \`\`\`json
            [
                {"pregunta":"¿...?","opciones":["a)...","b)...","c)..."],"respuesta":"b) ..."},
                ...
            ]
            \`\`\`
        **No incluyas** texto previo ni posterior, **no** uses markdown ni ningún otro formato: **solo** el JSON. Extrae la información y organízala de la manera que consideres más adecuada. A partir de ese contenido, elabora ${numPreguntas} preguntas de opción múltiple estrictamente basadas en el texto. Cada pregunta debe incluir tres posibles respuestas, de las cuales solo una será la correcta. Convierte cada pregunta en un objeto JSON donde la clave principal sea "pregunta" y el valor sea el texto de la pregunta. Dentro de cada objeto, incluye una clave "opciones" cuyo valor sea un array de strings con las tres opciones de respuesta, y una clave "respuesta" que contenga la letra de la opción correcta.
        ${texto ? `\nTexto fuente:\n${texto}\n` : ''}`;
        }
        async function llamarGemini(data) {
            const url =
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyCM1ERzhhDdON5dWNUXbO4MNWgHZqDFp4E";
            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });
            return res.json();
        }

        function limpiarJsonCrudo(texto) {
            return texto.replace(/```json|```/g, '').trim();
        }

        function procesarRespuestaGemini(res) {
            limpiarMensajeExamen();
            const rawText = res?.candidates?.[0]?.content?.parts?.[0]?.text || '';
            const jsonText = limpiarJsonCrudo(rawText);
            try {
                const preguntas = JSON.parse(jsonText);

                if (!Array.isArray(preguntas)) {
                    throw new Error('La respuesta no es un array.');
                }

                renderizarFormulario(preguntas);
                mostrarMensajeExamen('exito', '¡Preguntas generadas correctamente! Ahora puedes revisar y publicar el examen.');
            } catch (e) {
                mostrarMensajeExamen('error', "Error al procesar las preguntas generadas. Revisa el texto fuente o intenta de nuevo.");
                console.error(e);
            }
        }

        async function enviarEntrada() {
            const modo = document.getElementById('modoEntrada').value;
            const numPreguntas = parseInt(document.getElementById('numPreguntas').value) || 5;

            if (modo === 'imagen') {
                const input = document.getElementById('imagen');
                const file = input.files[0];
                if (!file) {
                    alert('Por favor selecciona una imagen.');
                    return;
                }
                mostrarSpinner(true);
                try {
                    const base64 = await convertirABase64(file);
                    const data = {
                        contents: [{
                            parts: [{
                                    "text": construirPrompt(numPreguntas)
                                },
                                {
                                    inline_data: {
                                        mime_type: file.type,
                                        data: base64.split(',')[1]
                                    }
                                }
                            ]
                        }]
                    };
                    const res = await llamarGemini(data);
                    mostrarSpinner(false);
                    procesarRespuestaGemini(res);
                } catch (err) {
                    mostrarSpinner(false);
                    document.getElementById('respuesta').textContent = 'Error: ' + err.message;
                }
            } else if (modo === 'texto') {
                const texto = document.getElementById('textoFuente').value.trim();
                if (!texto) {
                    alert('Por favor escribe el texto.');
                    return;
                }
                mostrarSpinner(true);
                const data = {
                    contents: [{
                        parts: [{
                            "text": construirPrompt(numPreguntas, texto)
                        }]
                    }]
                };
                try {
                    const res = await llamarGemini(data);
                    mostrarSpinner(false);
                    procesarRespuestaGemini(res);
                } catch (err) {
                    mostrarSpinner(false);
                    document.getElementById('respuesta').textContent = 'Error: ' + err.message;
                }
            }
        }

        function renderizarFormulario(preguntas) {
            const contenedor = document.getElementById('contenedorFormulario');
            contenedor.innerHTML = '';

            let html = `<form id="formularioPreguntas" class="gy-4 bg-white p-4 rounded-3 shadow border" method="POST" action="{{ route('examen.guardar') }}">
        @csrf
            <input type="hidden" name="evaluacion_id" id="evaluacion_id" value="{{ $evaluacion_id }}">
            <input type="hidden" name="jsonFinal" id="jsonFinal">
        
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-secondary">{{ $titulo }}</h5>
            </div>    
        `;
            preguntas.forEach((pregunta, index) => {
                html += `
                <div id="pregunta_${index}" class="gy-3 p-3 rounded border">
                    <label class="fw-semibold text-primary">Pregunta:</label>
                    <input type="text" class="form-control mb-2" name="pregunta_${index}" value="${pregunta.pregunta.replace(/"/g, '&quot;')}" />

                <div class="mb-2">
                    <label class="fw-semibold">Opciones:</label>
                    <input type="text" class="form-control my-1" name="opcion_${index}_a" value="${pregunta.opciones[0].replace(/"/g, '&quot;')}" placeholder="Opción a)" />
                    <input type="text" class="form-control my-1" name="opcion_${index}_b" value="${pregunta.opciones[1].replace(/"/g, '&quot;')}" placeholder="Opción b)" />
                    <input type="text" class="form-control my-1" name="opcion_${index}_c" value="${pregunta.opciones[2].replace(/"/g, '&quot;')}" placeholder="Opción c)" />
                </div>

                <div class="mb-2">
                    <label class="fw-semibold">Respuesta correcta:</label>
                    <select class="form-select" name="respuesta_${index}">
                    <option value="a" ${pregunta.respuesta.startsWith('a') ? 'selected' : ''}>a)</option>
                    <option value="b" ${pregunta.respuesta.startsWith('b') ? 'selected' : ''}>b)</option>
                    <option value="c" ${pregunta.respuesta.startsWith('c') ? 'selected' : ''}>c)</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="fw-semibold">Puntuación:</label>
                    <input type="number" class="form-control puntuacion-input" name="puntuacion_${index}" min="1" max="100" value="1" />
                </div>
                </div>
                <hr class="border-secondary">
                `;
            });
            html += `
            <button type="submit"
                id="enviarJsonBtn"
                class="mt-3 w-100 btn btn-primary fw-bold py-3 rounded">
                Publicar Examen
            </button>
</form>
<div class="alert alert-info mt-3 fw-bold text-center">
    Total de puntuación: <span id="totalPuntuacion">0</span>
</div>
            
            `;
            contenedor.innerHTML = html;

            // Cambia el evento para el submit del formulario:
            document.getElementById('formularioPreguntas').addEventListener('submit', function(e) {
                // Generar el JSON antes de enviar
                const form = e.target;
                const preguntasEditadas = [];
                for (let i = 0; i < preguntas.length; i++) {
                    const pregunta = form[`pregunta_${i}`].value;
                    const opciones = [
                        form[`opcion_${i}_a`].value,
                        form[`opcion_${i}_b`].value,
                        form[`opcion_${i}_c`].value
                    ];
                    const respuesta = form[`respuesta_${i}`].value;
                    const puntuacion = parseInt(form[`puntuacion_${i}`].value) || 1;
                    preguntasEditadas.push({
                        pregunta,
                        opciones,
                        respuesta,
                        puntuacion
                    });
                }
                const jsonStr = JSON.stringify(preguntasEditadas, null, 2);
                document.getElementById('jsonFinal').value = jsonStr;
                // El formulario se enviará normalmente
            });

            function actualizarTotalPuntuacion() {
                const inputs = document.querySelectorAll('.puntuacion-input');
                let total = 0;
                inputs.forEach(input => {
                    total += parseInt(input.value) || 0;
                });
                document.getElementById('totalPuntuacion').textContent = total;
            }

            actualizarTotalPuntuacion();
            document.querySelectorAll('.puntuacion-input').forEach(input => {
                input.addEventListener('input', actualizarTotalPuntuacion);
            });
        }

        function mostrarMensajeExamen(tipo, mensaje) {
            const div = document.getElementById('mensajeExamen');
            div.className = 'alert alert-' + (tipo === 'exito' ? 'success' : 'danger');
            div.textContent = mensaje;
            div.classList.remove('d-none');
        }
        function limpiarMensajeExamen() {
            const div = document.getElementById('mensajeExamen');
            div.className = 'alert d-none';
            div.textContent = '';
        }

        function enviarAlturaIframe() {
            const altura = document.body.scrollHeight;
            parent.postMessage({
                type: "iframeHeight",
                height: altura
            }, "*");
        }
        window.addEventListener("load", enviarAlturaIframe);
        window.addEventListener("resize", enviarAlturaIframe);
        const observer = new MutationObserver(enviarAlturaIframe);
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
</body>

</html>
