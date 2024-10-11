@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Crear Nueva Categoría</h2>

        <form action="{{ route('categoria.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre_categoria">Nombre de la Categoría</label>
                <input type="text" name="nombre_categoria" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success" style="background-color: #cc6633;">Crear</button>
            <a href="{{ route('categoria.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
