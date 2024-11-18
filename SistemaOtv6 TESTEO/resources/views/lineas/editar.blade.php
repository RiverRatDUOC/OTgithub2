@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
    @include('layouts.sidebar.dashboard')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <h2 class="mb-4">Editar Línea</h2>

            <form action="{{ route('lineas.update', $linea->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre de la Línea -->
                <div class="form-group">
                    <label for="nombre_linea">Nombre de la Línea</label>
                    <input type="text" name="nombre_linea" class="form-control" value="{{ $linea->nombre_linea }}" required>
                </div>

                <!-- Seleccionar Subcategoría -->
                <div class="form-group">
                    <label for="cod_subcategoria">Subcategoría</label>
                    <select name="cod_subcategoria" id="cod_subcategoria" class="form-control" required>
                        <option value="">Seleccione una Subcategoría</option>
                        @foreach($subcategorias as $subcategoria)
                            <option value="{{ $subcategoria->id }}" {{ $linea->cod_subcategoria == $subcategoria->id ? 'selected' : '' }}>
                                {{ $subcategoria->nombre_subcategoria }}
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
