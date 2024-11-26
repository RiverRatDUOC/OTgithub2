@extends('layouts.master')

@section('content')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Editar Servicio -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Editar Servicio</h2>
                </div>

                <!-- Formulario de Edición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Editar Información del Servicio
                    </div>
                    <div class="card-body">

                        <!-- Mensaje de éxito con SweetAlert2 -->
                        @if(session('success'))
                        <div id="success-message-edit" class="d-none">
                            <span id="success-type">{{ session('success_type', 'editar') }}</span>
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

                        <form action="{{ route('servicios.update', $servicio->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre_servicio">Nombre del Servicio</label>
                                <input type="text" name="nombre_servicio" id="nombre_servicio" class="form-control" value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}" required>
                                @error('nombre_servicio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_tipo_servicio">Tipo de Servicio</label>
                                <select name="cod_tipo_servicio" id="cod_tipo_servicio" class="form-control" required>
                                    <option value="" disabled>Seleccione un tipo de servicio</option>
                                    @foreach($tiposServicio as $tipo)
                                    <option value="{{ $tipo->id }}" {{ (old('cod_tipo_servicio', $servicio->cod_tipo_servicio) == $tipo->id) ? 'selected' : '' }}>
                                        {{ optional($tipo)->descripcion_tipo_servicio }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_tipo_servicio')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_sublinea">Sublínea</label>
                                <select name="cod_sublinea" id="cod_sublinea" class="form-control" required>
                                    <option value="" disabled>Seleccione una sublínea</option>
                                    @foreach($sublineas as $sublinea)
                                    <option value="{{ $sublinea->id }}" {{ (old('cod_sublinea', $servicio->cod_sublinea) == $sublinea->id) ? 'selected' : '' }}>
                                        {{ $sublinea->nombre_sublinea }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_sublinea')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
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
