<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Revisión de Examen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light text-dark">
    @php
    $puntajeTotal = array_sum(array_column($respuestas, 'valor_respuesta'));
@endphp
<form>
    @foreach($respuestas as $i => $respuesta)
        <div class="mb-3 p-3 border rounded">
            <div class="mb-2">
                <strong>{{ $i + 1 }}. {{ $respuesta['pregunta'] }}</strong>
                <span class="badge bg-info text-dark ms-2">Valor: {{ $respuesta['valor_pregunta'] }}</span>
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
</body>
</html>