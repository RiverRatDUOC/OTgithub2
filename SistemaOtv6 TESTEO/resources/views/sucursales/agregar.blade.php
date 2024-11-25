@extends('layouts.master')

@section('content')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Agregar Sucursal -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Sucursal</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading">Tutorial</h5>
                    <p>Agregue la siguiente información para agregar una sucursal correctamente:</p>
                    <ul>
                        <li><strong>Nombre de la Sucursal:</strong> Nombre de la sucursal.</li>
                        <li><strong>Teléfono:</strong> Número de teléfono de la sucursal.</li>
                        <li><strong>Dirección:</strong> Dirección física de la sucursal.</li>
                        <li><strong>Cliente:</strong> Cliente asociado con la sucursal.</li>
                    </ul>
                </div>

                <!-- Formulario de Adición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Agregar Información de la Sucursal
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message" class="d-none">
                            <span id="success-type">agregar</span>
                            <span id="module-name">Sucursal</span>
                            <span id="redirect-url">{{ route('sucursales.index') }}</span>
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

                        <form action="{{ route('sucursales.store') }}" method="POST">
                            @csrf

                            <!-- Información de la Sucursal -->
                            <div class="form-group">
                                <label for="nombre_sucursal">Nombre de la Sucursal</label>
                                <input type="text" name="nombre_sucursal" id="nombre_sucursal" class="form-control" value="{{ old('nombre_sucursal') }}" required>
                                @error('nombre_sucursal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono_sucursal">Teléfono</label>
                                <input type="text" name="telefono_sucursal" id="telefono_sucursal" class="form-control" value="{{ old('telefono_sucursal') }}" required>
                                @error('telefono_sucursal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="direccion_sucursal">Dirección</label>
                                <input type="text" name="direccion_sucursal" id="direccion_sucursal" class="form-control" value="{{ old('direccion_sucursal') }}" required>
                                @error('direccion_sucursal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cliente_id">Cliente Asociado</label>
                                <select name="cliente_id" id="cliente_id" class="form-control" required>
                                    <option value="">Seleccione un Cliente</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_cliente }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>

                                <!-- Botón Cancelar -->
                                <a href="{{ route('sucursales.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
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
