@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<link rel="stylesheet" href="{{ URL::to('assets/css/profile.css') }}">

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2>Editar Modelo</h2>

                <form action="{{ route('modelos.update', $modelo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Categoría -->
                        <div class="col-md-4">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select name="categoria" id="categoria" class="form-control form-control-sm w-100">
                                <option value="">Seleccionar Categoría</option>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $categoria->id == $modelo->sublinea->linea->subcategoria->categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subcategoría -->
                        <div class="col-md-4">
                            <label for="subcategoria" class="form-label">Subcategoría</label>
                            <select name="subcategoria" id="subcategoria" class="form-control form-control-sm w-100">
                                <option value="">Seleccionar Subcategoría</option>
                                @foreach ($subcategorias as $subcategoria)
                                <option value="{{ $subcategoria->id }}" {{ $subcategoria->id == $modelo->sublinea->linea->subcategoria->id ? 'selected' : '' }}>
                                    {{ $subcategoria->nombre_subcategoria }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Línea -->
                        <div class="col-md-4">
                            <label for="linea" class="form-label">Línea</label>
                            <select name="linea" id="linea" class="form-control form-control-sm w-100">
                                <option value="">Seleccionar Línea</option>
                                @foreach ($lineas as $linea)
                                <option value="{{ $linea->id }}" {{ $linea->id == $modelo->sublinea->linea->id ? 'selected' : '' }}>
                                    {{ $linea->nombre_linea }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sublínea -->
                        <div class="col-md-4">
                            <label for="sublinea" class="form-label">Sublínea</label>
                            <select name="sublinea" id="sublinea" class="form-control form-control-sm w-100">
                                <option value="">Seleccionar Sublínea</option>
                                @foreach ($sublineas as $sublinea)
                                <option value="{{ $sublinea->id }}" {{ $sublinea->id == $modelo->sublinea->id ? 'selected' : '' }}>
                                    {{ $sublinea->nombre_sublinea }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Marca -->
                        <div class="col-md-4">
                            <label for="marca" class="form-label">Marca</label>
                            <select name="marca" id="marca" class="form-control form-control-sm w-100">
                                <option value="">Seleccionar Marca</option>
                                @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}" {{ $marca->id == $modelo->marca->id ? 'selected' : '' }}>
                                    {{ $marca->nombre_marca }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nombre del Modelo -->
                        <div class="col-md-4">
                            <label for="nombre_modelo" class="form-label">Nombre del Modelo</label>
                            <input type="text" name="nombre_modelo" id="nombre_modelo" class="form-control" value="{{ old('nombre_modelo', $modelo->nombre_modelo) }}">
                            @error('nombre_modelo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Part Number -->
                        <div class="col-md-4">
                            <label for="part_number_modelo" class="form-label">Part Number</label>
                            <input type="text" name="part_number_modelo" id="part_number_modelo" class="form-control" value="{{ old('part_number_modelo', $modelo->part_number_modelo) }}">
                            @error('part_number_modelo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Descripción Corta -->
                        <div class="col-md-4">
                            <label for="desc_corta_modelo" class="form-label">Descripción Corta</label>
                            <input type="text" name="desc_corta_modelo" id="desc_corta_modelo" class="form-control" value="{{ old('desc_corta_modelo', $modelo->desc_corta_modelo) }}">
                            @error('desc_corta_modelo')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">
                            Actualizar
                        </button>
                        <a href="{{ route('modelos.index') }}" class="btn btn-secondary" style="background-color: #cc6633; border-color: #cc6633;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection