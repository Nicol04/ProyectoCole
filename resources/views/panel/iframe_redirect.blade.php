<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Redirigiendo...</title>
</head>
<body>
<script>
    window.parent.postMessage({
        type: "redirect",
        url: "{{ $url }}",
        mensaje: "{{ $mensaje ?? '' }}",
        icono: "{{ $icono ?? '' }}"
    }, "*");
</script>
Redirigiendo...
</body>
</html>