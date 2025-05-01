<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/style/style_login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body> 
    <div class="login-container">
        <div class="container">

            <h2 class="titulo-coolvetica">INICIA SESIÓN</h2>
            <form action="/panel/index" method="post">
                <div class="input-container">
                    <i class="fa fa-user"></i>
                    <input type="text" name="name" placeholder="Nombre de usuario" required autofocus>
                </div>
                <div class="input-container">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <i class="fa fa-eye" id="togglePassword"></i>
                </div>
                <div class="roles">
                    <input type="radio" id="docente" name="role" value="docente" required>
                    <label for="docente">Docente</label>
                
                    <input type="radio" id="estudiante" name="role" value="estudiante" required>
                    <label for="estudiante">Estudiante</label>
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
</html>
