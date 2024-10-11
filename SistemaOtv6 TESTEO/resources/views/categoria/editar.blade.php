@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
    @include('layouts.sidebar.dashboard')

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
                <button type="submit" class="btn btn-success" style="background-color: #cc6633;">Guardar cambios</button>
                <a href="{{ route('parametros.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </main>
@endsection
