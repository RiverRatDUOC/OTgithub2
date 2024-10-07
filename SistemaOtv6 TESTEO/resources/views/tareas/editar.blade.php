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
                <!-- Editar Tarea -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Editar Tarea</h2>
                </div>

                <!-- Formulario de Edición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Editar Información de la Tarea
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito -->
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
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

                        <form action="{{ route('tareas.update', $tarea->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre_tarea">Nombre de la Tarea</label>
                                <input type="text" name="nombre_tarea" id="nombre_tarea" class="form-control" value="{{ old('nombre_tarea', $tarea->nombre_tarea) }}" required>
                                @error('nombre_tarea')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tiempo_tarea">Tiempo de la Tarea (en minutos)</label>
                                <input type="number" name="tiempo_tarea" id="tiempo_tarea" class="form-control" value="{{ old('tiempo_tarea', $tarea->tiempo_tarea) }}" required>
                                @error('tiempo_tarea')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_servicio">Servicio Asociado</label>
                                <select name="cod_servicio" id="cod_servicio" class="form-control" required>
                                    <option value="" disabled>Seleccione un servicio</option>
                                    @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}" {{ $tarea->cod_servicio == $servicio->id ? 'selected' : '' }}>
                                        {{ $servicio->nombre_servicio }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_servicio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('tareas.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
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

<script src="{{ asset('assets/js/mensajes/mensajes.js') }}"></script>
@endsection
