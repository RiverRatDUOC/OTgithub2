<nav class="navbar navbar-expand-lg navbar-light">

    <a class="navbar-brand" href="{{ route('home.page') }}">
        <img src="{{ asset('assets/image/logo-small.png') }}" alt="Logo Sc Informatica" height="40">
    </a>


    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Collection of nav links, forms, and other content for toggling -->
    <!-- Collection of nav links, forms, and other content for toggling -->
    <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
        <div class="navbar-nav ml-auto">
            <div class="navbar-form-wrapper">
                <form class="navbar-form form-inline">
                    <div class="input-group search-box" style="border-bottom: 2px solid #ff9900;">
                        <input type="text" id="search" class="form-control" placeholder="Search Here..." style="border-bottom: none;">
                        <div class="input-group-append">
                            <span class="input-group-text" style="border-bottom: none;">
                                <i class="material-icons">&#xE8B6;</i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <img src="{{ asset('assets/image/logo-small.png') }}" alt="Logo Sc Informatica" height="40">

            <!-- Contenedor de perfil y logout -->
            <div class="nav-item nav-link">
                <div style="display: flex; align-items: center;">
                    <!-- Imagen de perfil del cliente (temporalmente un círculo morado) -->
                    <div style="width: 40px; height: 40px; border-radius: 50%; background-color: purple; margin-right: 10px;">
                    </div>
                    <!-- Información del usuario -->
                    <div>
                        <p style="margin: 0; color: #333333;">{{ auth()->user()->email ?? 'usuario@example.com' }}</p>
                        <p style="margin: 0; color: #333333;">ID: {{ auth()->user()->id ?? '12345' }}</p>
                    </div>

                    <!-- Enlace de Logout solo en el icono -->
                    <a href="" class="nav-item nav-link" style="margin-left: 10px;">
                        <i class="fa fa-sign-out"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>