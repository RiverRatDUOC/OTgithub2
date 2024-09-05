@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <h2 class="text-center mt-3">Agregar Contacto</h2>

        <!-- Sección Tutorial -->
        <div class="alert alert-info mt-4" role="alert">
            <h5 class="alert-heading">Tutorial</h5>
            <p>Agregue la siguiente información para agregar un contacto correctamente:</p>
            <ul>
                <li><strong>Nombre del Contacto:</strong> Nombre completo del contacto.</li>
                <li><strong>Teléfono:</strong> Número de teléfono del contacto.</li>
                <li><strong>Departamento:</strong> Departamento en el que trabaja el contacto.</li>
                <li><strong>Cargo:</strong> Cargo del contacto en la empresa.</li>
                <li><strong>Correo Electrónico:</strong> Correo electrónico del contacto.</li>
                <li><strong>Sucursal:</strong> Sucursal a la que pertenece el contacto.</li>
            </ul>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contactos.store') }}" method="POST">
                    @csrf

                    <!-- Información del Contacto -->
                    <div class="form-group">
                        <label for="nombre_contacto">Nombre del Contacto</label>
                        <input type="text" class="form-control @error('nombre_contacto') is-invalid @enderror" id="nombre_contacto" name="nombre_contacto" value="{{ old('nombre_contacto') }}" required>
                        @error('nombre_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono_contacto">Teléfono</label>
                        <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto') }}" required>
                        @error('telefono_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="departamento_contacto">Departamento</label>
                        <input type="text" class="form-control @error('departamento_contacto') is-invalid @enderror" id="departamento_contacto" name="departamento_contacto" value="{{ old('departamento_contacto') }}">
                        @error('departamento_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cargo_contacto">Cargo</label>
                        <input type="text" class="form-control @error('cargo_contacto') is-invalid @enderror" id="cargo_contacto" name="cargo_contacto" value="{{ old('cargo_contacto') }}">
                        @error('cargo_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email_contacto">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email_contacto') is-invalid @enderror" id="email_contacto" name="email_contacto" value="{{ old('email_contacto') }}" required>
                        @error('email_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cod_sucursal">Sucursal</label>
                        <select class="form-control @error('cod_sucursal') is-invalid @enderror" id="cod_sucursal" name="cod_sucursal" required>
                            <option value="">Seleccionar Sucursal</option>
                            @foreach ($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}" {{ old('cod_sucursal') == $sucursal->id ? 'selected' : '' }}>
                                {{ $sucursal->nombre_sucursal }}
                            </option>
                            @endforeach
                        </select>
                        @error('cod_sucursal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center mt-4">
                        <!-- Botón Guardar -->
                        <button type="submit" class="btn btn-primary me-auto" style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-save"></i> Guardar
                        </button>

                        <!-- Botón Cancelar -->
                        <a href="{{ route('contactos.index') }}" class="btn btn-secondary ms-auto">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection