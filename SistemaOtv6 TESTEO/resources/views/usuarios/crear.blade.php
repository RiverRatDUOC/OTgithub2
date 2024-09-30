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
                <!-- Mostrar mensajes de error si los hay -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf

                    <!-- Campo Nombre de Usuario -->
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="{{ old('nombre_usuario') }}" required>
                    </div>

                    <!-- Campo Email -->
                    <div class="mb-3">
                        <label for="email_usuario" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_usuario" name="email_usuario" value="{{ old('email_usuario') }}" required>
                    </div>

                    <!-- Campo Contraseña -->
                    <div class="mb-3">
                        <label for="password_usuario" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password_usuario" name="password_usuario" required>
                    </div>

                    <!-- Campo Confirmar Contraseña -->
                    <div class="mb-3">
                        <label for="password_usuario_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_usuario_confirmation" name="password_usuario_confirmation" required>
                    </div>



                    <!-- Botón de Crear Usuario -->
                    <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Crear Usuario</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection