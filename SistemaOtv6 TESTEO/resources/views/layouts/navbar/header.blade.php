<nav class="navbar navbar-expand-lg navbar-light">

    <a class="navbar-brand" href="{{ route('home.page') }}">
        <img src="{{ asset('assets/image/logo-small.png') }}" alt="Logo Sc Informatica" height="40">
    </a>

    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
        <div class="navbar-nav ml-auto">
            <!-- Contenedor de perfil y logout -->
            <div class="nav-item nav-link">
                <div style="display: flex; align-items: center;">
                    <!-- Imagen de perfil del cliente (temporalmente un círculo morado) -->
                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: purple; margin-right: 10px;">
                    </div>
                    <!-- Información del usuario -->
                    <div>
                        <p style="margin: 0; color: #333333;">{{ auth()->user()->email_usuario ?? 'usuario@example.com' }}</p>
                        <p style="margin: 0; color: #333333;">ID Usuario: {{ auth()->user()->id ?? '12345' }}</p>
                        <p style="margin: 0; color: #333333;">
                            ID Técnico: {{ auth()->user()->tecnico->id ?? 'No asignado' }}


                        </p>
                    </div>

                    <!-- Enlace de Logout solo en el icono -->
                    <a href="{{ route('logout') }}" class="nav-item nav-link" style="margin-left: 10px;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
