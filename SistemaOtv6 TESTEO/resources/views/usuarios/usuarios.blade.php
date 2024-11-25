@extends('layouts.master')

@section('content')

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center text-center mt-3">
            <h2>Usuarios</h2>
            <div class="d-flex align-items-center">
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary ms-auto" style="background-color: #cc6633; border-color: #cc6633;">
                    <i class="bi bi-plus"></i> Agregar
                </a>
            </div>
        </div>

        <form action="{{ route('usuarios.buscar') }}" method="get" class="input-group mt-3">
            <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por nombre, correo, roles...">
            <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
        </form>

        <!-- Tabla de usuarios -->
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped text-center shadow" style="width: 100%;">
                <thead class="table-primary">
                    <tr>
                        <th>#ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nombre_usuario }}</td> <!-- Cambiado a nombre_usuario -->
                        <td>{{ $user->email_usuario }}</td> <!-- Cambiado a email_usuario -->
                        <td>
                            @foreach ($user->roles as $role)
                            <span class="badge" style="background-color: {{ $role->color }}; color: white;">{{ $role->name }}</span>
                            @endforeach
                        </td>

                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <!-- <form action="{{ route('tecnicos.create', $user->id) }}" method="GET" style="margin-right: 10px;">
                                    <button type="submit" class="btn btn-success" style="background-color: #28a745; border-color: #28a745;">
                                        <i class="fas fa-plus"></i> Agregar Técnico
                                    </button>
                                </form> -->

                                <!-- Botón Editar -->
                                <form action="{{ route('usuarios.editar', $user->id) }}" method="GET" style="margin-right: 10px;">
                                    <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                </form>
                                <!-- Botón Eliminar -->
                                <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este usuario?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="background-color: #d9534f; border-color: #d43f3a;">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            @if ($users->hasPages())
            <nav>
                <ul class="pagination" style="color: #cc6633;">
                    {{-- Previous Page Link --}}
                    @if ($users->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" rel="prev" style="color: #cc6633;">&lsaquo;</a>
                    </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if ($page == $users->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}" style="color: #cc6633;">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next" style="color: #cc6633;">&rsaquo;</a>
                    </li>
                    @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                    </li>
                    @endif
                </ul>
            </nav>
            @endif
        </div>
    </div>
</main>
@endsection
