@extends('layouts.master')

@section('content')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <h2 class="mb-4">Editar Categoría</h2>

            <form action="{{ route('categoria.update', $categoria->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre_categoria">Nombre de la Categoría</label>
                    <input type="text" name="nombre_categoria" class="form-control"
                        value="{{ $categoria->nombre_categoria }}" required>
                </div>
                <!-- Botónes -->
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
