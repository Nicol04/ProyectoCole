<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Revisión de Examen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .aprendibot-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #ffc107;
            color: #212529;
            font-weight: bold;
            font-size: 1.5rem;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            transition: background 0.2s;
        }
        .aprendibot-btn:hover {
            background: #ff9800;
            color: #fff;
        }
    </style>
</head>
<body class="bg-light text-dark">
    @php
        $puntajeTotal = array_sum(array_column($respuestas, 'valor_respuesta'));
    @endphp

    @if (auth()->check())
        @php
            $roleId = auth()->user()->roles->first()?->id;
        @endphp
    @endif
<form>
    @foreach($respuestas as $i => $respuesta)

@php
            $letraCorrecta = strtoupper($respuesta['respuesta_correcta']);
            $opcionCorrecta = $respuesta['opciones'][ord($respuesta['respuesta_correcta']) - 97];
            $textoPregunta = "{$respuesta['pregunta']} (Respuesta correcta: {$letraCorrecta}) {$opcionCorrecta}";
        @endphp
        <div class="mb-3 p-3 border rounded">
            <div class="mb-2 d-flex align-items-center">
                <strong>{{ $i + 1 }}. {{ $respuesta['pregunta'] }}</strong>
                <span class="badge bg-info text-dark ms-2">Valor: {{ $respuesta['valor_pregunta'] }}</span>
                @if ($roleId == 3)
                <button type="button"
                    class="aprendibot-btn ms-3 btn-aprendibot"
                    title="AprendiBot"
                    data-pregunta="{{ $textoPregunta }}">
                    ¿?
                </button>
                @endif
            </div>
            @foreach($respuesta['opciones'] as $key => $opcion)
                @php
                    $letra = chr(97 + $key);
                    $esCorrecta = $letra == $respuesta['respuesta_correcta'];
                    $esSeleccionada = $letra == $respuesta['respuesta_seleccionada'];
                    $clase = '';
                    if ($esSeleccionada && $esCorrecta) {
                        $clase = 'border border-success bg-success bg-opacity-10';
                    } elseif ($esSeleccionada && !$esCorrecta) {
                        $clase = 'border border-danger bg-danger bg-opacity-10';
                    } elseif ($esCorrecta) {
                        $clase = 'border border-success bg-success bg-opacity-10';
                    }
                @endphp
                <div class="form-check mb-1 {{ $clase }}">
                    <input class="form-check-input" type="radio" disabled
                        @if ($esSeleccionada) checked @endif>
                    <label class="form-check-label">
                        {{ strtoupper($letra) }}) {{ $opcion }}
                        @if ($esCorrecta)
                            <span class="badge bg-success ms-2">Correcta</span>
                        @endif
                        @if ($esSeleccionada && !$esCorrecta)
                            <span class="badge bg-danger ms-2">Tu respuesta</span>
                        @elseif($esSeleccionada && $esCorrecta)
                            <span class="badge bg-success ms-2">Tu respuesta</span>
                        @endif
                    </label>
                </div>
            @endforeach
            <div class="mt-2">
                <span class="fw-bold">Valor obtenido: </span>
                <span class="{{ $respuesta['valor_respuesta'] > 0 ? 'text-success' : 'text-danger' }}">
                    {{ $respuesta['valor_respuesta'] }}
                </span>
            </div>
        </div>
    @endforeach
    <div class="alert alert-primary fw-bold text-center">
        Puntaje total obtenido: {{ $puntajeTotal }}
    </div>
</form>
    @if ($roleId == 3)
        @include('panel.ia.chat')
    @endif
</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            document.querySelectorAll('.btn-aprendibot').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const chatSection = document.getElementById('draggableChat');
                    const openBtn = document.getElementById('chatOpenBtn');
                    if (chatSection && chatSection.style.display === 'none') {
                        chatSection.style.display = '';
                        if (openBtn) openBtn.style.display = 'none';
                    }

                    const pregunta = this.getAttribute('data-pregunta');
                    const msgerInput = document.getElementById('msgerInput');
                    const msgerForm = document.getElementById('msgerForm');
                    if (msgerInput && msgerForm) {
                        msgerInput.value = pregunta;
                        msgerForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                    }
                });
            });
        }, 500);
    });
</script>