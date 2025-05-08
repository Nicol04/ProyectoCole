@if (session('mensaje') && session('icono'))
    <script>
        Swal.fire({
            title: "Mensaje",
            text: "{{ session('mensaje') }}",
            icon: "{{ session('icono') }}"
        });
    </script>
@endif
