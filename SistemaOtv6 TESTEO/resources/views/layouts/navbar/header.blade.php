<link rel="stylesheet" href="{{ asset('assets/css/components/comp-navbar.css') }}">

<nav class="navbar navbar-light">
    <!-- Botón para ocultar/mostrar el sidebar -->
    <button id="toggleSidebarButton" class="nav-item nav-link">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Logo -->
    <a class="navbar-brand" href="{{ route('home.page') }}">
        <img src="{{ asset('assets/image/logo-small.png') }}" alt="Logo Sc Informatica">
    </a>

    <!-- Contenido del navbar -->
    <div class="navbar-nav ml-auto">
        <!-- Contenedor de perfil y logout -->
        <div class="nav-item nav-link">
            <div style="display: flex; align-items: center;">
                <!-- Imagen de perfil -->
                <div class="profile-circle"></div>

                <!-- Información del usuario -->
                <div class="user-info">
                    <p>{{ auth()->user()->email_usuario ?? 'usuario@example.com' }}</p>
                    <p>ID Usuario: {{ auth()->user()->id ?? '12345' }}</p>
                    <p>ID Técnico: {{ auth()->user()->tecnico->id ?? 'No asignado' }}</p>
                </div>

                <!-- Enlace de Logout -->
                <a href="{{ route('logout') }}" class="nav-item nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i>
                </a>

                <!-- Formulario de logout -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
