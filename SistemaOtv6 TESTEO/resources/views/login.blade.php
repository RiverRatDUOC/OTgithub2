<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <!-- Iconos y estilos -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
</head>

<body class="dark-background">
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Imagen lateral -->
            <div class="login-image-wrapper">
                <img src="{{ asset('assets/image/logo-small.png') }}" alt="Logo" class="login-logo">
            </div>

            <!-- Formulario -->
            <div class="login-form-wrapper">
                <h5 class="center-align">INGRESE A SU CUENTA</h5>
                <p class="center-align" style="color: #CCCCCC;">Ingrese sus credenciales a continuación</p>

                <!-- Formulario de inicio de sesión -->
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <!-- Campo de Correo Electrónico -->
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        <label for="email">Correo Electrónico</label>
                    </div>



                    <!-- Campo de Contraseña -->
                    <div class="input-field">
                        <i class="material-icons prefix" style="color: #FF9900;">lock</i>
                        <input type="password" id="password" name="password" required>
                        <label for="password">Contraseña</label>

                    </div>

                    <!-- Botón de envío -->
                    <div class="input-field center-align" style="margin-top: 20px;">
                        <button type="submit" class="btn waves-effect waves-light login-btn">Ingresar</button>
                    </div>

                    @error('email')
                    <span class="red-text">{{ $message }}</span>
                    @enderror
                    @error('password')
                    <span class="red-text">{{ $message }}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>
