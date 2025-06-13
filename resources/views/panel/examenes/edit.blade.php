<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <main class="container w-75 mx-auto gy-4">
        <section class="formulario-ia bg-white border border-secondary p-4 rounded-3 shadow-lg gy-3">
            <div class="mb-3">
                <label class="form-label small fw-semibold mb-2 text-secondary">📄 Estado del examen:</label>
                <div id="mensajeExamen" class="alert d-none"></div>
            </div>
            <section class="d-flex flex-column align-items-center justify-content-center my-4">
                @if ($evaluacion->imagen_url)
                    <img src="{{ asset('storage/' . $evaluacion->imagen_url) }}" alt="Imagen de la evaluación"
                        class="img-fluid mb-3 shadow">
                @endif
                @if ($evaluacion->texto)
                    <textarea class="form-control mb-3 mx-auto" rows="5" style="max-width: 500px; min-width: 300px; resize: vertical;"
                        readonly>{{ $evaluacion->texto }}</textarea>
                @endif
            </section>
            <section id="contenedorFormulario" class="gy-3"></section>
        </section>
    </main>

    <script>
        const examenPreguntaId = @json($examenPregunta->id ?? null);
        document.addEventListener('DOMContentLoaded', function() {
            renderizarFormulario(@json($preguntas_json), examenPreguntaId);
        });

        function renderizarFormulario(preguntas) {
            const contenedor = document.getElementById('contenedorFormulario');
            contenedor.innerHTML = '';
let html = '';
            html += `
    <form id="formularioPreguntas" class="gy-4 bg-white p-4 rounded-3 shadow border" method="POST" action="{{ route('examen.actualizar', $examenPregunta->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="evaluacion_id" id="evaluacion_id" value="{{ $evaluacion_id }}">
        <input type="hidden" name="jsonFinal" id="jsonFinal">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-secondary">{{ $evaluacion->titulo }}</h5>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Cantidad de intentos permitidos:</label>
            <input type="number" class="form-control" name="cantidad_intentos" id="cantidad_intentos"
                min="1" max="10" value="{{ $evaluacion->cantidad_intentos ?? 1 }}">
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">¿Examen supervisado?</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="es_supervisado" name="es_supervisado" value="1" {{ $evaluacion->es_supervisado ? 'checked' : '' }}>
                <label class="form-check-label" for="es_supervisado">
                    Supervisado
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">¿El material es visible para estudiantes?</label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="visible" name="visible" value="1" {{ $evaluacion->visible ? 'checked' : '' }}>
                <label class="form-check-label" for="visible">
                    Visible para estudiantes
                </label>
            </div>
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
                    <input type="number" class="form-control puntuacion-input" name="puntuacion_${index}" min="1" max="100" value="${pregunta.puntuacion ?? 1}" />
                </div>
            </div>
            <hr class="border-secondary">
        `;
            });
            html += `
        <button type="submit"
            id="enviarJsonBtn"
            class="mt-3 w-100 btn btn-primary fw-bold py-3 rounded">
            Actualizar examen
        </button>
    </form>
    <div class="alert alert-info mt-3 fw-bold text-center">
        Total de puntuación: <span id="totalPuntuacion">0</span>
    </div>
    `;
            contenedor.innerHTML = html;

            // Lógica para el submit
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

        function ajustarAlturaIframe() {
            window.parent.postMessage({
                type: "iframeHeight",
                height: document.body.scrollHeight
            }, "*");
        }
        window.onload = ajustarAlturaIframe;
        window.addEventListener('resize', ajustarAlturaIframe);
    </script>
</body>
</html>
