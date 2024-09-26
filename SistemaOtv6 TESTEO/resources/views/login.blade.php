<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/materialize.css') }}">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #141923;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .login-card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .input-field label {
            color: #546e7a;
        }

        .input-field input[type="email"],
        .input-field input[type="password"] {
            border: 1px solid #ccc;
            box-shadow: none;
            border-radius: 4px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 8px;
            display: block;
        }

        .forgot-password {
            float: right;
            margin-top: -10px;
        }

        .btn-login {
            background-color: #11283b;
            width: 100%;
        }

        .btn-login:hover {
            background-color: #082249;
        }
    </style>
</head>

<body>
    <main>
        <div class="login-container">
            <div class="card z-depth-1 login-card">
                <form class="col s12" action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="row center">
                        <img class="responsive-img" src="img/q.jpg" alt="Logo">
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email" required />
                            @error('email')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" required />
                            @error('password')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                            <div class="forgot-password">
                                <a class="blue-text" href="#!"><b>¿Olvidaste tu contraseña?</b></a>
                            </div>
                        </div>
                    </div>

                    <div class="row center">
                        <button type="submit" class="btn btn-large waves-effect btn-login">Entrar</button>
                    </div>
                    @if (session('error'))
                    <div class="red-text center">
                        {{ session('error') }}
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>

</html>