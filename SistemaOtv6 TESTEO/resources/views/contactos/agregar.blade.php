@extends('layouts.master')

@section('content')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Agregar Contacto -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Contacto</h2>
                </div>

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

                <!-- Formulario de Adición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Agregar Información del Contacto
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message" class="d-none">
                            <span id="success-type">{{ session('success_type', 'agregar') }}</span>
                            <span id="module-name">Contacto</span>
                            <span id="redirect-url">{{ route('contactos.index') }}</span>
                        </div>
                        @endif

                        <!-- Mensaje de error -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('contactos.store') }}" method="POST">
                            @csrf

                            <!-- Información del Contacto -->
                            <div class="form-group">
                                <label for="nombre_contacto">Nombre del Contacto</label>
                                <input type="text" name="nombre_contacto" id="nombre_contacto" class="form-control" value="{{ old('nombre_contacto') }}" required>
                                @error('nombre_contacto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono_contacto">Teléfono</label>
                                <input type="text" name="telefono_contacto" id="telefono_contacto" class="form-control" value="{{ old('telefono_contacto') }}" required>
                                @error('telefono_contacto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="departamento_contacto">Departamento</label>
                                <input type="text" name="departamento_contacto" id="departamento_contacto" class="form-control" value="{{ old('departamento_contacto') }}">
                                @error('departamento_contacto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cargo_contacto">Cargo</label>
                                <input type="text" name="cargo_contacto" id="cargo_contacto" class="form-control" value="{{ old('cargo_contacto') }}">
                                @error('cargo_contacto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email_contacto">Correo Electrónico</label>
                                <input type="email" name="email_contacto" id="email_contacto" class="form-control" value="{{ old('email_contacto') }}" required>
                                @error('email_contacto')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_sucursal">Sucursal</label>
                                <select class="form-control" id="cod_sucursal" name="cod_sucursal" required>
                                    <option value="">Seleccionar Sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ old('cod_sucursal') == $sucursal->id ? 'selected' : '' }}>
                                        {{ $sucursal->nombre_sucursal }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_sucursal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>

                                <!-- Botón Cancelar -->
                                <a href="{{ route('contactos.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-times-circle"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Incluye el archivo JavaScript -->
<script src="{{ asset('assets/js/mensajes/mensajes.js') }}"></script>
@endsection
