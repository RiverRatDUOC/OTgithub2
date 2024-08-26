<aside class="col-12 col-md-2 p-0 bg-dark flex-shrink-1" style="overflow-x: auto;">
    <nav class="navbar navbar-expand navbar-dark bg-dark flex-md-column flex-row align-items-start py-2" style="width: 250px;">
        <div class="collapse navbar-collapse">
            <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between" style="max-height: calc(100vh - 60px); overflow-y: auto;">
                <li class="nav-item">
                    @can('ordenes.index')
                    <a class="nav-link pl-0 text-white {{ Request::is('ordenes*') ? 'active' : '' }}" href="{{ route('ordenes.index') }}">
                        <i class="fas fa-shopping-cart"></i> <span>Órdenes</span>
                    </a>
                    @endcan
                </li>

                <!-- Aquí van el resto de los elementos del menú -->
                <li class="nav-item">
                    @can('clientes.index')
                    <a class="nav-link pl-0 text-white {{ Request::is('clientes*') ? 'active' : '' }}" href="{{ route('clientes.index') }}"><i class="fas fa-user-friends"></i> <span>Clientes</span></a>
                    @endcan
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('sucursales*') ? 'active' : '' }}" href="{{ route('sucursales.index') }}">
                        <i class="fas fa-building"></i> <span>Sucursales</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('servicios*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">
                        <i class="fas fa-concierge-bell"></i> <span>Servicios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('tareas*') ? 'active' : '' }}" href="{{ route('tareas.index') }}">
                        <i class="fas fa-tasks"></i> <span>Tareas</span>
                    </a>
                </li>




                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('convenios*') ? 'active' : '' }}" href="#"><i class="fas fa-handshake"></i> <span>Convenios</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('repuestos*') ? 'active' : '' }}" href="#"><i class="fas fa-tools"></i> <span>Repuestos</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('tecnicos*') ? 'active' : '' }}" href="{{ route('tecnicos.index') }}">
                        <i class="fas fa-user-cog"></i> <span>Técnicos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('modelos*') ? 'active' : '' }}" href="{{ route('modelos.index') }}">
                        <i class="fas fa-desktop"></i> <span>Modelos</span></a>
                </li>


                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('parametros*') ? 'active' : '' }}" href="#"><i class="fas fa-cogs"></i> <span>Parámetros</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('reclamos*') ? 'active' : '' }}" href="#"><i class="fas fa-exclamation-triangle"></i> <span>Reclamos</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('seguimiento*') ? 'active' : '' }}" href="#"><i class="fas fa-binoculars"></i> <span>Seguimiento</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('agendamiento*') ? 'active' : '' }}" href="#"><i class="fas fa-calendar-alt"></i> <span>Agendamiento</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('contrato*') ? 'active' : '' }}" href="#"><i class="fas fa-file-contract"></i> <span>Contrato</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                        <i class="fas fa-user-shield"></i> <span>Roles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pl-0 text-white {{ Request::is('usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                        <i class="fas fa-users"></i> <span>Usuarios</span>
                    </a>
                </li>


                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a class="nav-link pl-0 text-white" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Salir</span>
                </a>
            </ul>
        </div>
    </nav>
</aside>






<!-- <li class="nav-item dropdown">
    @can('clientes.index')
    <a class="nav-link dropdown-toggle pl-0 text-white {{ Request::is('clientes*') ? 'active' : '' }}" href="#" id="clientesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-friends"></i> <span>Clientes</span>
    </a>
    <div class="dropdown-menu bg-dark" aria-labelledby="clientesDropdown">
        <a class="dropdown-item text-white" href="{{ route('clientes.index') }}">Clientes</a>
        <a class="dropdown-item text-white" href="#">Opción 2</a>
        <a class="dropdown-item text-white" href="#">Opción 3</a>
    </div>
    @endcan
</li> -->