<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Examen Dinámico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="h-100 overflow-auto px-3 py-3 bg-light text-dark">

    @php
        $examen = [
            [
                "pregunta" => "¿Cuál es el lenguaje principal utilizado en el backend?",
                "opciones" => [
                    "a) Java",
                    "b) FastAPI",
                    "c) Python"
                ],
                "respuesta" => "b",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Qué tipo de solicitud se envía al backend para registrar una asistencia?",
                "opciones" => [
                    "a) GET",
                    "b) POST",
                    "c) PUT"
                ],
                "respuesta" => "b",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Qué componente envía la imagen para el reconocimiento facial?",
                "opciones" => [
                    "a) Interfaz Web",
                    "b) API REST",
                    "c) ESP32-CAM"
                ],
                "respuesta" => "c",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Cómo se envían las imágenes al backend?",
                "opciones" => [
                    "a) Solo base64",
                    "b) Solo multipart",
                    "c) base64 o multipart"
                ],
                "respuesta" => "c",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Qué componente del frontend está especificado en el diagrama?",
                "opciones" => [
                    "a) Astro + HTMX",
                    "b) React",
                    "c) Angular"
                ],
                "respuesta" => "a",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Qué componente gestiona la consulta de rostros registrados?",
                "opciones" => [
                    "a) API REST",
                    "b) Reconocimiento Facial",
                    "c) Registro de Asistencias"
                ],
                "respuesta" => "b",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Qué tipo de base de datos se utiliza para almacenar la información?",
                "opciones" => [
                    "a) MySQL",
                    "b) MongoDB",
                    "c) PostgreSQL"
                ],
                "respuesta" => "c",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Qué componente gestiona las solicitudes GET para obtener información de alumnos y asistencias?",
                "opciones" => [
                    "a) Interfaz Web",
                    "b) API REST",
                    "c) ESP32-CAM"
                ],
                "respuesta" => "b",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Cuál es la función principal del componente Registro de Asistencias?",
                "opciones" => [
                    "a) Consultar rostros",
                    "b) Insertar asistencia",
                    "c) Mostrar la interfaz web"
                ],
                "respuesta" => "b",
                "puntuacion" => 1
            ],
            [
                "pregunta" => "¿Qué solicitudes GET realiza el Frontend?",
                "opciones" => [
                    "a) /api/alumnos, /api/asistencias",
                    "b) /api/asistencia",
                    "c) Consulta rostros registrados"
                ],
                "respuesta" => "a",
                "puntuacion" => 1
            ],
        ];
    @endphp

    <main class="container w-75 mx-auto gy-4">
        <section class="bg-white border border-secondary p-4 rounded-3 shadow-lg gy-3">
            <h2 class="fs-1 fw-bold text-center text-primary mb-4">Examen</h2>

            <!-- Formulario generado dinámicamente -->
            <section id="contenedorFormulario" class="gy-3"></section>
        </section>
    </main>

    <script>
        // El examen se pasa desde PHP como JSON
        const preguntas = @json($examen);

        let resultadoJson = null;
        let puntuacionFinal = null;

        renderizarFormulario(preguntas);

        function renderizarFormulario(preguntas) {
            const contenedor = document.getElementById('contenedorFormulario');
            contenedor.innerHTML = '';

            let html = `<form id="formularioPreguntas" class="gy-4 bg-white p-4 rounded-3 shadow border">`;

            preguntas.forEach((pregunta, index) => {
                const letraCorrecta = pregunta.respuesta.trim().toLowerCase();

                html += `
                <div id="pregunta_${index}" data-correct="${letraCorrecta}" class="gy-3 p-3 rounded border">
                  <h3 class="fs-5 fw-semibold text-primary">${pregunta.pregunta}</h3>`;

                ['a', 'b', 'c'].forEach((letra, i) => {
                    const opcion = pregunta.opciones[i];
                    html += `
                    <label class="d-flex align-items-center gap-3 py-1 rounded hover-bg-light transition">
                      <input type="radio"
                             name="pregunta_${index}"
                             value="${letra}"
                             class="form-check-input text-primary" />
                      <span class="text-dark">${opcion}</span>
                    </label>`;
                });

                html += `</div>
                <hr class="border-secondary">`;
            });

            html += `
              <button type="submit"
                      class="mt-3 w-100 btn btn-success fw-bold py-3 rounded">
                Finalizar
              </button>
            </form>`;

            contenedor.innerHTML = html;

            const formEl = document.getElementById('formularioPreguntas');
            formEl.addEventListener('submit', function (e) {
                e.preventDefault();
                let score = 0;
                let respuestasUsuario = [];

                preguntas.forEach((pregunta, index) => {
                    const letraCorrecta = pregunta.respuesta.trim().toLowerCase();
                    const seleccionada = this[`pregunta_${index}`]?.value || null;
                    const divPregunta = document.getElementById(`pregunta_${index}`);

                    divPregunta.querySelectorAll('label').forEach(label => {
                        label.classList.remove('bg-success', 'bg-danger');
                    });

                    if (seleccionada === letraCorrecta) {
                        score += pregunta.puntuacion || 1;
                        const labelCorrecto = divPregunta.querySelector(`input[value="${letraCorrecta}"]`).closest('label');
                        labelCorrecto.classList.add('bg-success');
                    } else {
                        if (seleccionada) {
                            const labelErroneo = divPregunta.querySelector(`input[value="${seleccionada}"]`).closest('label');
                            labelErroneo.classList.add('bg-danger');
                        }
                        const labelCorrecto = divPregunta.querySelector(`input[value="${letraCorrecta}"]`).closest('label');
                        labelCorrecto.classList.add('bg-success');
                    }

                    respuestasUsuario.push({
                        pregunta: pregunta.pregunta,
                        opciones: pregunta.opciones,
                        respuesta_correcta: letraCorrecta,
                        respuesta_usuario: seleccionada
                    });
                });

                resultadoJson = JSON.stringify(respuestasUsuario, null, 2);
                puntuacionFinal = score;

                document.getElementById('php_resultado_json').value = resultadoJson;
                document.getElementById('php_puntuacion').value = puntuacionFinal;

                let resultadoDiv = document.getElementById('resultadoScore');
                if (!resultadoDiv) {
                    resultadoDiv = document.createElement('div');
                    resultadoDiv.id = 'resultadoScore';
                    resultadoDiv.className = 'mt-3 text-center fs-4 fw-semibold text-primary';
                    formEl.after(resultadoDiv);
                }
                resultadoDiv.textContent = `Obtuviste ${score} de ${preguntas.length} respuestas correctas.`;
            });
        }
    </script>

    <!-- Campos ocultos para pasar datos a PHP -->
    <form id="phpForm" method="POST" action="">
        @csrf
        <input type="hidden" id="php_resultado_json" name="resultado_json" value="">
        <input type="hidden" id="php_puntuacion" name="puntuacion" value="">
    </form>

    <div id="jsonGenerado" class="alert alert-info mt-4 d-none">
        <strong>Resultado JSON:</strong>
        <pre id="jsonGeneradoContent"></pre>
        <strong>Puntuación:</strong> <span id="jsonGeneradoScore"></span>
    </div>

    <script>
        // Mostrar el JSON generado y la puntuación después de enviar el formulario
        function mostrarJsonGenerado(json, score) {
            const div = document.getElementById('jsonGenerado');
            const pre = document.getElementById('jsonGeneradoContent');
            const scoreSpan = document.getElementById('jsonGeneradoScore');
            pre.textContent = json;
            scoreSpan.textContent = score;
            div.classList.remove('d-none');
        }

        // Modifica el submit para mostrar el JSON generado
        document.addEventListener('DOMContentLoaded', function () {
            const formEl = document.getElementById('formularioPreguntas');
            if (formEl) {
                formEl.addEventListener('submit', function (e) {
                    e.preventDefault();
                    mostrarJsonGenerado(
                        document.getElementById('php_resultado_json').value,
                        document.getElementById('php_puntuacion').value
                    );
                });
            }
        });
    </script>
</body>
</html>