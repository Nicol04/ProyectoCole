<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Examen Dinámico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body class="h-100 overflow-auto px-3 py-3 bg-light text-dark">
    <main class="container w-75 mx-auto gy-4">
        <section class="bg-white border border-secondary p-4 rounded-3 shadow-lg gy-3">
            <h2 class="fs-1 fw-bold text-center text-primary mb-4">Examen</h2>
            <section class="d-flex flex-column align-items-center justify-content-center my-4">

                @if ($evaluacion->visible)
                    @if ($evaluacion->imagen_url)
                        <img src="{{ asset('storage/' . $evaluacion->imagen_url) }}" alt="Imagen de la evaluación"
                            class="img-fluid mb-3 shadow">
                    @endif
                    @if ($evaluacion->texto)
                        <textarea class="form-control mb-3 mx-auto" rows="5" style="max-width: 500px; min-width: 300px; resize: vertical;"
                            readonly>{{ $evaluacion->texto }}</textarea>
                    @endif
                @else
                    <div class="alert alert-warning text-center w-100">Suerte en tu examen!</div>
                @endif
            </section>
            <section id="contenedorFormulario" class="gy-3"></section>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // El examen se pasa desde PHP como JSON
            const preguntas = @json($preguntas_json);

            function renderizarFormulario(preguntas) {
                const contenedor = document.getElementById('contenedorFormulario');
                let html = `
                <form id="formularioPreguntas" method="POST" action="{{ route('respuesta_estudiante.store') }}">
                    @csrf
                    <input type="hidden" name="examen_pregunta_id" value="{{ $examenPregunta->id ?? '' }}">
                    <input type="hidden" name="intento_id" value="{{ $intento_id ?? '' }}">
                `;

                preguntas.forEach((pregunta, index) => {
                    html += `
                    <div class="mb-4 p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="fw-semibold mb-0">${index + 1}. ${pregunta.pregunta}</h5>
                            <span class="badge bg-info text-dark">Puntaje: ${pregunta.puntuacion}</span>
                        </div>
                    `;

                    pregunta.opciones.forEach((opcion, i) => {
                        const letra = String.fromCharCode(97 + i);
                        html += `
                        <div class="form-check mb-1">
                            <input class="form-check-input"
                                type="radio"
                                name="respuestas[${index}]"
                                id="pregunta_${index}_${letra}"
                                value="${letra}">
                            <label class="form-check-label" for="pregunta_${index}_${letra}">
                                ${opcion}
                            </label>
                        </div>
                        `;
                    });

                    html += `</div>`;
                });

                html +=
                    `<button type="submit" class="btn btn-success w-100 fw-bold py-2">Finalizar</button></form>`;
                contenedor.innerHTML = html;

                // Ahora sí, agrega el event listener al formulario recién creado
                const formEl = document.getElementById('formularioPreguntas');
                formEl.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let score = 0;
                    let respuestasUsuario = [];
                    let todasRespondidas = true;

                    // ...existing code...
                    preguntas.forEach((pregunta, index) => {
                        const letraCorrecta = pregunta.respuesta.trim().toLowerCase();
                        const radios = document.getElementsByName(`respuestas[${index}]`);
                        let seleccionada = null;
                        radios.forEach(radio => {
                            if (radio.checked) seleccionada = radio.value;
                        });

                        if (!seleccionada) {
                            todasRespondidas = false;
                        }

                        // Valor de la pregunta
                        const valorPregunta = pregunta.puntuacion || 1;
                        // Valor de la respuesta (si es correcta, igual al valor de la pregunta, si no, 0)
                        const valorRespuesta = (seleccionada === letraCorrecta) ? valorPregunta : 0;

                        if (valorRespuesta > 0) {
                            score += valorRespuesta;
                        }

                        respuestasUsuario.push({
                            pregunta: pregunta.pregunta,
                            opciones: pregunta.opciones,
                            respuesta_correcta: letraCorrecta,
                            respuesta_seleccionada: seleccionada,
                            valor_pregunta: valorPregunta,
                            valor_respuesta: valorRespuesta
                        });
                    });
                    // ...existing code...

                    if (!todasRespondidas) {
                        Swal.fire({
                            icon: 'warning',
                            title: '¡Faltan respuestas!',
                            text: 'Por favor, responde todas las preguntas antes de finalizar.',
                            confirmButtonText: 'Entendido'
                        });
                        return;
                    }

                    // Agrega el JSON de respuestas a un input oculto
                    let inputJson = document.createElement('input');
                    inputJson.type = 'hidden';
                    inputJson.name = 'respuesta_json';
                    inputJson.value = JSON.stringify(respuestasUsuario);
                    formEl.appendChild(inputJson);

                    // Envía el formulario
                    formEl.submit();
                });
            }

            function mostrarJsonGenerado(json, score) {
                const div = document.getElementById('jsonGenerado');
                const pre = document.getElementById('jsonGeneradoContent');
                const scoreSpan = document.getElementById('jsonGeneradoScore');
                pre.textContent = json;
                scoreSpan.textContent = score;
                div.classList.remove('d-none');
            }

            // Renderiza el formulario al cargar la página
            renderizarFormulario(preguntas);
        });

        function sendIframeHeight() {
            const height = document.body.scrollHeight;
            window.parent.postMessage({
                type: "iframeHeight",
                height: height
            }, "*");
        }
        window.onload = sendIframeHeight;
        window.onresize = sendIframeHeight;
        setTimeout(sendIframeHeight, 500);
    </script>
</body>

</html>
