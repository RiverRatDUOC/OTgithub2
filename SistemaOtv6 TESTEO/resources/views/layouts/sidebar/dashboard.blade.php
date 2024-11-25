
<link rel="stylesheet" href="{{ asset('assets/css/components/comp-sidebar.css') }}">
<aside id="sidebar" class="sidebar">
    <nav class="navbar navbar-expand navbar-dark">
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <!-- Órdenes -->
                <li class="nav-item">
                    @can('ordenes.index')
                    <a class="nav-link {{ Request::is('ordenes*') ? 'active' : '' }}" href="{{ route('ordenes.index') }}">
                        <i class="fas fa-shopping-cart"></i> <span>Órdenes</span>
                    </a>
                    @endcan
                </li>

                <!-- Clientes -->
                <li class="nav-item">
                    @can('clientes.index')
                    <a class="nav-link {{ Request::is('clientes*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                        <i class="fas fa-user-friends"></i> <span>Clientes</span>
                    </a>
                    @endcan
                </li>

                <!-- Sucursales -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sucursales*') ? 'active' : '' }}" href="{{ route('sucursales.index') }}">
                        <i class="fas fa-building"></i> <span>Sucursales</span>
                    </a>
                </li>

                <!-- Contactos -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('contactos*') ? 'active' : '' }}" href="{{ route('contactos.index') }}">
                        <i class="fas fa-address-book"></i> <span>Contactos</span>
                    </a>
                </li>

                <!-- Servicios -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('servicios*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">
                        <i class="fas fa-concierge-bell"></i> <span>Servicios</span>
                    </a>
                </li>

                <!-- Tareas -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('tareas*') ? 'active' : '' }}" href="{{ route('tareas.index') }}">
                        <i class="fas fa-tasks"></i> <span>Tareas</span>
                    </a>
                </li>

                <!-- Técnicos -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('tecnicos*') ? 'active' : '' }}" href="{{ route('tecnicos.index') }}">
                        <i class="fas fa-toolbox"></i> <span>Técnicos</span>
                    </a>
                </li>

                <!-- Convenios -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('convenios*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-handshake"></i> <span>Convenios</span>
                    </a>
                </li>

                <!-- Repuestos -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('repuestos*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-tools"></i> <span>Repuestos</span>
                    </a>
                </li>

                <!-- Modelos -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('modelos*') ? 'active' : '' }}" href="{{ route('modelos.index') }}">
                        <i class="fas fa-desktop"></i> <span>Modelos</span>
                    </a>
                </li>

                <!-- Dispositivos -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('dispositivos*') ? 'active' : '' }}" href="{{ route('dispositivos.index') }}">
                        <i class="fas fa-laptop"></i> <span>Dispositivos</span>
                    </a>
                </li>

                <!-- Parámetros -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('parametros*') ? 'active' : '' }}" href="{{ route('parametros.index') }}">
                        <i class="fas fa-cogs"></i> <span>Parámetros</span>
                    </a>
                </li>

                <!-- Reclamos -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('reclamos*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-exclamation-triangle"></i> <span>Reclamos</span>
                    </a>
                </li>

                <!-- Seguimiento -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('seguimiento*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-binoculars"></i> <span>Seguimiento</span>
                    </a>
                </li>

                <!-- Agendamiento -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('agendamiento*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-calendar-alt"></i> <span>Agendamiento</span>
                    </a>
                </li>

                <!-- Contrato -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('contrato*') ? 'active' : '' }}" href="#">
                        <i class="fas fa-file-contract"></i> <span>Contrato</span>
                    </a>
                </li>

                <!-- Roles -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="fas fa-user-shield"></i> <span>Roles</span>
                    </a>
                </li>

                <!-- Usuarios -->
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                        <i class="fas fa-users"></i> <span>Usuarios</span>
                    </a>
                </li>

                <!-- Salir -->
                <li class="nav-item">
                    <a class="nav-link logout" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> <span>Salir</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</aside>
