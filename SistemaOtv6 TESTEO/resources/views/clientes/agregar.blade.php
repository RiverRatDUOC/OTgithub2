@extends('layouts.master')

@section('content')


<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Agregar Cliente -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Cliente</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading">Tutorial</h5>
                    <p>Agregue la siguiente información para agregar un cliente correctamente:</p>
                    <ul>
                        <li><strong>Nombre del Cliente:</strong> Nombre completo del cliente.</li>
                        <li><strong>RUT:</strong> RUT del cliente (formato: xx.xxx.xxx-x).</li>
                        <li><strong>Correo Electrónico:</strong> Correo electrónico de contacto.</li>
                        <li><strong>Teléfono:</strong> Número de teléfono del cliente.</li>
                        <li><strong>Sitio Web:</strong> Página web del cliente, si está disponible.</li>
                    </ul>
                </div>

                <!-- Formulario de Adición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Agregar Información del Cliente
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message" class="d-none">
                            <span id="success-type">{{ session('success_type', 'agregar') }}</span>
                            <span id="module-name">Cliente</span>
                            <span id="redirect-url">{{ route('clientes.index') }}</span>
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

                        <form action="{{ route('clientes.store') }}" method="POST">
                            @csrf

                            <!-- Información del Cliente -->
                            <div class="form-group">
                                <label for="nombre_cliente">Nombre del Cliente</label>
                                <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="{{ old('nombre_cliente') }}" required>
                                @error('nombre_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="rut_cliente">RUT</label>
                                <input type="text" name="rut_cliente" id="rut_cliente" class="form-control" value="{{ old('rut_cliente') }}" required>
                                @error('rut_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email_cliente">Correo Electrónico</label>
                                <input type="email" name="email_cliente" id="email_cliente" class="form-control" value="{{ old('email_cliente') }}" required>
                                @error('email_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono_cliente">Teléfono</label>
                                <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-control" value="{{ old('telefono_cliente') }}" required>
                                @error('telefono_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="web_cliente">Sitio Web</label>
                                <input type="text" name="web_cliente" id="web_cliente" class="form-control" value="{{ old('web_cliente') }}" required>
                                @error('web_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>

                                <!-- Botón Cancelar -->
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
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
