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

            <div class="form-group">
                <label for="nombre_linea">Nombre de la Línea</label>
                <input type="text" name="nombre_linea" class="form-control"
                    value="{{ $linea->nombre_linea }}" required>
            </div>

            <div class="form-group">
                <label for="cod_subcategoria">Subcategoría</label>
                <select name="cod_subcategoria" id="cod_subcategoria" class="form-control" required>
                    <option value="">Seleccione una subcategoría</option>
                    @foreach ($subcategorias as $subcategoria)
                    <option value="{{ $subcategoria->id }}" {{ $linea->cod_subcategoria == $subcategoria->id ? 'selected' : '' }}>
                        {{ $subcategoria->nombre_subcategoria }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success" style="background-color: #cc6633;">Guardar cambios</button>
            <a href="{{ route('parametros.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</main>
@endsection