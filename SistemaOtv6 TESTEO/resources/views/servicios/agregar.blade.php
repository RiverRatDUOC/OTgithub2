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
                <!-- Agregar Servicio -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Servicio</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading">Tutorial</h5>
                    <p>Agregue la siguiente información para agregar un servicio correctamente:</p>
                    <ul>
                        <li><strong>Nombre del Servicio:</strong> Nombre del servicio que se está creando.</li>
                        <li><strong>Tipo de Servicio:</strong> Selecciona el tipo de servicio asociado.</li>
                        <li><strong>Sublinea:</strong> Selecciona la sublínea correspondiente.</li>
                    </ul>
                </div>

                <!-- Formulario de Adición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Agregar Información del Servicio
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message" class="d-none">
                            <span id="success-type">agregar</span>
                            <span id="module-name">Servicio</span>
                            <span id="redirect-url">{{ route('servicios.index') }}</span>
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

                        <form action="{{ route('servicios.store') }}" method="POST">
                            @csrf

                            <!-- Información del Servicio -->
                            <div class="form-group">
                                <label for="nombre_servicio">Nombre del Servicio</label>
                                <input type="text" name="nombre_servicio" id="nombre_servicio" class="form-control" value="{{ old('nombre_servicio') }}" required>
                                @error('nombre_servicio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_tipo_servicio">Tipo de Servicio</label>
                                <select name="cod_tipo_servicio" id="cod_tipo_servicio" class="form-control" required>
                                    <option value="" disabled selected>Seleccione un tipo de servicio</option>
                                    @foreach($tiposServicio as $tipo)
                                    <option value="{{ $tipo->id }}">{{ optional($tipo)->descripcion_tipo_servicio }}</option>
                                    @endforeach
                                </select>
                                @error('cod_tipo_servicio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_sublinea">Sublínea</label>
                                <select name="cod_sublinea" id="cod_sublinea" class="form-control" required>
                                    <option value="" disabled selected>Seleccione una sublínea</option>
                                    @foreach($sublineas as $sublinea)
                                    <option value="{{ $sublinea->id }}">{{ $sublinea->nombre_sublinea }}</option>
                                    @endforeach
                                </select>
                                @error('cod_sublinea')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>

                                <!-- Botón Cancelar -->
                                <a href="{{ route('servicios.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
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
