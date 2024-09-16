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
                <!-- Editar Sucursal -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Editar Sucursal</h2>
                </div>

                <!-- Formulario de Edición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Editar Información de la Sucursal
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message-edit" class="d-none">
                            <span id="success-type">{{ session('success_type', 'editar') }}</span>
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

                        <form action="{{ route('sucursales.update', $sucursal->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre_sucursal">Nombre</label>
                                <input type="text" name="nombre_sucursal" id="nombre_sucursal" class="form-control" value="{{ old('nombre_sucursal', $sucursal->nombre_sucursal) }}" required>
                                @error('nombre_sucursal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono_sucursal">Teléfono</label>
                                <input type="text" name="telefono_sucursal" id="telefono_sucursal" class="form-control" value="{{ old('telefono_sucursal', $sucursal->telefono_sucursal) }}" required>
                                @error('telefono_sucursal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="direccion_sucursal">Dirección</label>
                                <input type="text" name="direccion_sucursal" id="direccion_sucursal" class="form-control" value="{{ old('direccion_sucursal', $sucursal->direccion_sucursal) }}" required>
                                @error('direccion_sucursal')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cliente_id">Cliente Asociado</label>
                                <select name="cliente_id" id="cliente_id" class="form-control" required>
                                    <option value="" disabled>Seleccione un cliente</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ $sucursal->cliente_id == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre_cliente }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
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