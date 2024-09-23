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
                <!-- Agregar Sucursal -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Dispositivo</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading">Tutorial</h5>
                    <p>Agregue la siguiente información para agregar un dispositivo correctamente:</p>
                    <ul>
                        <li><strong>Número de Serie:</strong> Ingrese el número de serie del dispositivo.</li>
                        <li><strong>Modelo:</strong> Seleccione el modelo correspondiente al dispositivo.</li>
                        <li><strong>Sucursal:</strong> Seleccione la sucursal donde se registrará el dispositivo.</li>
                    </ul>
                </div>

                <div class="card mt-3">
                    <div class="card-header">Información del Dispositivo</div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('dispositivos.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="numero_serie_dispositivo">Número de Serie</label>
                                <input type="text" name="numero_serie_dispositivo" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="cod_modelo">Modelo</label>
                                <select name="cod_modelo" class="form-control" required>
                                    <option value="">Seleccione un Modelo</option>
                                    @foreach($modelos as $modelo)
                                    <option value="{{ $modelo->id }}">{{ $modelo->nombre_modelo }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="cod_sucursal">Sucursal</label>
                                <select name="cod_sucursal" class="form-control" required>
                                    <option value="">Seleccione una Sucursal</option>
                                    @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">{{ $sucursal->nombre_sucursal }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar
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
</main>

<!-- Incluye el archivo JavaScript -->
<script src="{{ asset('assets/js/mensajes/mensajes.js') }}"></script>
@endsection