<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/style/style_login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo_colegio.png') }}">

</head>
<body>
    <div class="login-container">
        <div class="container">
            <a href="/panel/index">
                <img src="{{ asset('assets/img/logo_colegio.png') }}" alt=""alt="" width="80">
            </a>
            <h2 class="titulo-coolvetica">INICIA SESIÓN</h2>
            <form action="{{ route('login.submit') }}" method="post">
                @csrf
                <div class="input-container">
                    @if (($message = Session::get('mensaje')) && ($icono = Session::get('icono')))
                    <script>
                        Swal.fire({
                            title: "Mensaje",
                            text: "{{ $message }}",
                            icon: "{{ $icono }}"
                        });
                    </script>
                    @endif
                </div>
                <div class="input-container">
                    <i class="fa fa-user"></i>
                    <input type="text" name="name" placeholder="Nombre de usuario" required autofocus maxlength="30" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]{1,30}" title="Solo letras, hasta 30 caracteres">
                </div>
                <div class="input-container">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" required autofocus maxlength="30" required>
                    <i class="fa fa-eye" id="togglePassword"></i>
                </div>
                <div class="remember-me-container">
                    <input type="checkbox" name="remember" id="remember-me">
                    <label for="remember-me">Recuérdame</label>
                </div>
                <button type="submit" class="login-button">INGRESAR</button>
            </form>
        </div>
    </div>
</body>
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const passwordInput = document.querySelector("input[name='password']");

    togglePassword.addEventListener("click", function () {
        // Alternar tipo de input
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);

        // Cambiar ícono
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
</script>
</html>
