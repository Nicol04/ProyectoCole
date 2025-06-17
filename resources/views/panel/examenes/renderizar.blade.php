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
                    <div class="mb-2 text-center">
                        @if ($evaluacion->visible)
                            <span class="badge bg-success fs-5 py-2 px-4" style="font-size: 1.3rem;">
                                <i class="bi bi-eye-fill"></i> La imagen es visible para estudiantes
                            </span>
                        @else
                            <span class="badge bg-danger fs-5 py-2 px-4" style="font-size: 1.3rem;">
                                <i class="bi bi-eye-slash-fill"></i> La imagen no es visible para estudiantes
                            </span>
                        @endif
                    </div>
                @endif
                @if ($evaluacion->texto)
                    <textarea class="form-control mb-3 mx-auto" rows="5" style="max-width: 500px; min-width: 300px; resize: vertical;"
                        readonly>{{ $evaluacion->texto }}</textarea>
                    <div class="mb-2 text-center">
                        @if ($evaluacion->visible)
                            <span class="badge bg-success fs-5 py-2 px-4" style="font-size: 1.3rem;">
                                <i class="bi bi-eye-fill"></i> El texto es visible para estudiantes
                            </span>
                        @else
                            <span class="badge bg-danger fs-5 py-2 px-4" style="font-size: 1.3rem;">
                                <i class="bi bi-eye-slash-fill"></i> El texto no es visible para estudiantes
                            </span>
                        @endif
                    </div>
                @endif
            </section>

            <section id="contenedorFormulario" class="gy-3"></section>

        </section>
        
    </main>

    <script>
        const examenPreguntaId = @json($examenPregunta->id ?? null);
        const evaluacionId = @json($evaluacion_id ?? null);
        document.addEventListener('DOMContentLoaded', function() {
            renderizarFormulario(@json($preguntas_json));
        });

        function renderizarFormulario(preguntas) {
            const contenedor = document.getElementById('contenedorFormulario');
            contenedor.innerHTML = '';

            // Supervisado o no supervisado
            let supervisadoHtml = `
        <div class="mb-3">
            @if ($evaluacion->es_supervisado)
                <span class="badge bg-success px-3 py-2">
                    <i class="fa fa-eye"></i> Supervisado
                </span>
            @else
                <span class="badge bg-primary px-3 py-2">
                    <i class="fa fa-robot"></i> No Supervisado
                </span>
            @endif
        </div>
    `;

            let html = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            ${supervisadoHtml}
        </div>
    `;

            preguntas.forEach((pregunta, index) => {
                // Resalta la respuesta correcta en verde
                const getOptionClass = (letra) =>
                    pregunta.respuesta.startsWith(letra) ?
                    'bg-success bg-opacity-25 border-success fw-bold' :
                    '';
                html += `
        <div id="pregunta_${index}" class="gy-3 p-3 rounded border mb-4 shadow-sm bg-light">
        <div class="mb-2">
            <span class="badge bg-info text-dark">Puntuación: ${pregunta.puntuacion ?? 1}</span>
        </div>
        <label class="fw-semibold text-primary">Pregunta:</label>
        <input type="text" class="form-control mb-2" value="${pregunta.pregunta.replace(/"/g, '&quot;')}" readonly />

        <div class="mb-2">
            <label class="fw-semibold">Opciones:</label>
            <input type="text" class="form-control my-1 ${getOptionClass('a')}" value="${pregunta.opciones[0].replace(/"/g, '&quot;')}" placeholder="Opción a)" readonly />
            <input type="text" class="form-control my-1 ${getOptionClass('b')}" value="${pregunta.opciones[1].replace(/"/g, '&quot;')}" placeholder="Opción b)" readonly />
            <input type="text" class="form-control my-1 ${getOptionClass('c')}" value="${pregunta.opciones[2].replace(/"/g, '&quot;')}" placeholder="Opción c)" readonly />
        </div>
    </div>
    <hr class="border-secondary">
    `;
            });

            html += `
        <div class="text-end mt-4">
            <a href="/examen/${examenPreguntaId}/editar?evaluacion_id=${evaluacionId}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Editar
            </a>
        </div>
    `;
            contenedor.innerHTML = html;
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
