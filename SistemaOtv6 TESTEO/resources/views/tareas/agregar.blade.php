@extends('layouts.master')

@section('content')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Agregar Tarea -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Tarea</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading">Tutorial</h5>
                    <p>Agregue la siguiente información para agregar una tarea correctamente:</p>
                    <ul>
                        <li><strong>Nombre de la Tarea:</strong> Nombre de la tarea que se está creando.</li>
                        <li><strong>Servicio:</strong> Selecciona el servicio asociado a esta tarea.</li>
                        <li><strong>Tiempo de Tarea:</strong> Indica el tiempo estimado para completar la tarea.</li>
                    </ul>
                </div>

                <!-- Formulario de Adición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Agregar Información de la Tarea
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message" class="d-none">
                            <span id="success-type">agregar</span>
                            <span id="module-name">Tarea</span>
                            <span id="redirect-url">{{ route('tareas.index') }}</span>
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

                        <form action="{{ route('tareas.store') }}" method="POST">
                            @csrf

                            <!-- Información de la Tarea -->
                            <div class="form-group">
                                <label for="nombre_tarea">Nombre de la Tarea</label>
                                <input type="text" name="nombre_tarea" id="nombre_tarea" class="form-control" value="{{ old('nombre_tarea') }}" required>
                                @error('nombre_tarea')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_servicio">Servicio</label>
                                <select name="cod_servicio" id="cod_servicio" class="form-control" required>
                                    <option value="" disabled selected>Seleccione un servicio</option>
                                    @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ optional($servicio)->nombre_servicio }}</option>
                                    @endforeach
                                </select>
                                @error('cod_servicio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tiempo_tarea">Tiempo de Tarea (en horas)</label>
                                <input type="number" name="tiempo_tarea" id="tiempo_tarea" class="form-control" value="{{ old('tiempo_tarea') }}" required>
                                @error('tiempo_tarea')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>

                                <!-- Botón Cancelar -->
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

<!-- Incluye el archivo JavaScript -->
<script src="{{ asset('assets/js/mensajes/mensajes.js') }}"></script>
@endsection
