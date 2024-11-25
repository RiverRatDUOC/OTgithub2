@extends('layouts.master')

@section('content')

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center text-center mt-3">
            <h2>Roles</h2>
            <div class="d-flex align-items-center">
                <a href="{{ route('roles.create') }}" class="btn btn-primary ms-auto" style="background-color: #cc6633; border-color: #cc6633;">
                    <i class="bi bi-plus"></i> Agregar
                </a>
            </div>
        </div>

        <form action="{{ route('roles.buscar') }}" method="GET" class="input-group mt-3">
            <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por..." style="border-color: #cc6633;">
            <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
        </form>

        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped text-center shadow">
                <thead class="table-primary">
                    <tr>
                        <th>#ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>
                            <span class="badge" style="background-color: {{ $role->color }}; color: white;">{{ $role->name }}</span>
                        </td>
                        <td>{{ $role->description }}</td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <form action="{{ route('roles.edit', $role->id) }}" method="GET" style="margin-right: 10px;">
                                    <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                </form>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar este rol?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
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
            {{ $roles->links() }}
        </div>
    </div>
</main>

@endsection
