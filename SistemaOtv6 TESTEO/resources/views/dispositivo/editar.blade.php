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
                <!-- Editar Dispositivo -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Editar Dispositivo</h2>
                </div>

                <!-- Formulario de Edición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Editar Información del Dispositivo
                    </div>
                    <div class="card-body">

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

                        <!-- Formulario -->
                        <form action="{{ route('dispositivos.update', $dispositivo->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="numero_serie_dispositivo">Número de Serie</label>
                                <input type="text" name="numero_serie_dispositivo" id="numero_serie_dispositivo" class="form-control" value="{{ old('numero_serie_dispositivo', $dispositivo->numero_serie_dispositivo) }}" required>
                                @error('numero_serie_dispositivo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_modelo">Modelo</label>
                                <select name="cod_modelo" id="cod_modelo" class="form-control" required>
                                    @foreach($modelos as $modelo)
                                    <option value="{{ $modelo->id }}" {{ $modelo->id == $dispositivo->cod_modelo ? 'selected' : '' }}>
                                        {{ $modelo->nombre_modelo }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_modelo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_sucursal">Sucursal</label>
                                <select name="cod_sucursal" id="cod_sucursal" class="form-control" required>
                                    @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ $sucursal->id == $dispositivo->cod_sucursal ? 'selected' : '' }}>
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
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>

                                <!-- Botón Cancelar -->
                                <a href="{{ route('dispositivos.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
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