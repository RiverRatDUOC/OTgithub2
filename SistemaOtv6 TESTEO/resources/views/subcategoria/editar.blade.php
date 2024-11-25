@extends('layouts.master')

@section('content')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <h2 class="mb-4">Editar Subcategoría</h2>

            <form action="{{ route('subcategoria.update', $subcategoria->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nombre de la Subcategoría -->
                <div class="form-group">
                    <label for="nombre_subcategoria">Nombre de la Subcategoría</label>
                    <input type="text" name="nombre_subcategoria" class="form-control"
                        value="{{ $subcategoria->nombre_subcategoria }}" required>
                </div>

                <!-- Seleccionar Categoría -->
                <div class="form-group">
                    <label for="cod_categoria">Categoría</label>
                    <select name="cod_categoria" id="cod_categoria" class="form-control" required>
                        <option value="">Seleccione una Categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $subcategoria->cod_categoria == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre_categoria }}
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
