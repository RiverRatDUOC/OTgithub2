@extends('layouts.master')

@section('content')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <h2 class="mb-4">Editar Sublínea</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>¡Error!</strong> Por favor, corrige los siguientes errores:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sublineas.update', $sublinea->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre de la Sublínea -->
                <div class="form-group">
                    <label for="nombre_sublinea">Nombre de la Sublínea</label>
                    <input type="text" name="nombre_sublinea" class="form-control" value="{{ $sublinea->nombre_sublinea }}" required>
                </div>

                <!-- Seleccionar Línea -->
                <div class="form-group">
                    <label for="cod_linea">Línea</label>
                    <select name="cod_linea" id="cod_linea" class="form-control" required>
                        <option value="">Seleccione una Línea</option>
                        @foreach($lineas as $linea)
                            <option value="{{ $linea->id }}" {{ $sublinea->cod_linea == $linea->id ? 'selected' : '' }}>
                                {{ $linea->nombre_linea }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <!-- Botón Guardar -->
                    <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="fas fa-save"></i> Guardar
                    </button>

                    <!-- Botón Cancelar -->
                    <a href="{{ route('parametros.index') }}" class="btn btn-secondary" style="background-color: #666666; border-color: #666666;">
                        <i class="fas fa-times-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
@endsection
