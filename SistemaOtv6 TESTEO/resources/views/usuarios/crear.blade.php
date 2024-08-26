@extends('layouts.master')
@include('layouts.navbar.header')
@section('content')
@include('layouts.sidebar.dashboard')
<link rel="stylesheet" href="{{ URL::to('assets/css/profile.css') }}">

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center text-center mt-3">
            <h2>Crear Usuario</h2>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="mb-3">
                        <label for="roles" class="form-label">Roles</label>
                        <div>
                            @foreach($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="role{{ $role->id }}" name="roles[]" value="{{ $role->id }}">
                                <label class="form-check-label" for="role{{ $role->id }}">
                                    {{ $role->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Crear Usuario</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection