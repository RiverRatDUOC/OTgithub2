@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<link rel="stylesheet" href="{{ URL::to('assets/css/profile.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Agregar Técnico -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Técnico</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading">Instrucciones</h5>
                    <p>Complete la siguiente información para agregar un técnico correctamente:</p>
                    <ul>
                        <li><strong>Nombre del Técnico:</strong> Nombre del técnico.</li>
                        <li><strong>RUT:</strong> RUT del técnico.</li>
                        <li><strong>Teléfono:</strong> Número de teléfono del técnico.</li>
                        <li><strong>Email:</strong> Correo electrónico del técnico.</li>
                        <li><strong>Precio por Hora:</strong> Tarifa por hora del técnico.</li>
                    </ul>
                </div>

                <!-- Formulario de Adición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Agregar Información del Técnico
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message" class="d-none">
                            <span id="success-type">agregar</span>
                            <span id="module-name">Técnico</span>
                            <span id="redirect-url">{{ route('tecnicos.index') }}</span>
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

                        <form action="{{ route('tecnicos.store') }}" method="POST">
                            @csrf

                            <!-- Nombre del Técnico -->
                            <div class="form-group">
                                <label for="nombre_tecnico">Nombre del Técnico</label>
                                <input type="text" name="nombre_tecnico" id="nombre_tecnico" class="form-control" value="{{ old('nombre_tecnico') }}" required>
                                @error('nombre_tecnico')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- RUT -->
                            <div class="form-group">
                                <label for="rut_tecnico">RUT</label>
                                <input type="text" name="rut_tecnico" id="rut_tecnico" class="form-control" value="{{ old('rut_tecnico') }}" required>
                                @error('rut_tecnico')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div class="form-group">
                                <label for="telefono_tecnico">Teléfono</label>
                                <input type="text" name="telefono_tecnico" id="telefono_tecnico" class="form-control" value="{{ old('telefono_tecnico') }}" required>
                                @error('telefono_tecnico')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email_tecnico">Email</label>
                                <input type="email" name="email_tecnico" id="email_tecnico" class="form-control" value="{{ old('email_tecnico') }}" required>
                                @error('email_tecnico')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Precio por Hora -->
                            <div class="form-group">
                                <label for="precio_hora_tecnico">Precio por Hora</label>
                                <input type="number" step="0.01" name="precio_hora_tecnico" id="precio_hora_tecnico" class="form-control" value="{{ old('precio_hora_tecnico') }}" required>
                                @error('precio_hora_tecnico')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>

                                <!-- Botón Cancelar -->
                                <a href="{{ route('tecnicos.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
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
