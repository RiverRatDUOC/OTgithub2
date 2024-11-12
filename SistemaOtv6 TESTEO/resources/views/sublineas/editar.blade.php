@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <h2 class="mb-4">Editar Sublínea</h2>

        <form action="{{ route('sublineas.update', $sublinea->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre_sublinea">Nombre de la Sublínea</label>
                <input type="text" name="nombre_sublinea" class="form-control"
                    value="{{ $sublinea->nombre_sublinea }}" required>
            </div>

            <div class="form-group">
                <label for="cod_linea">Línea</label>
                <select name="cod_linea" id="cod_linea" class="form-control" required>
                    <option value="">Seleccione una línea</option>
                    @foreach ($lineas as $linea)
                    <option value="{{ $linea->id }}" {{ $sublinea->cod_linea == $linea->id ? 'selected' : '' }}>
                        {{ $linea->nombre_linea }}
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