@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<link rel="stylesheet" href="{{ URL::to('assets/css/profile.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Agregar Subcategoría -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Subcategoría</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading"><strong>Tutorial</strong></h5>
                    <p>Siga las siguientes indicaciones para agregar una subcategoría correctamente:</p>
                    <ul>
                        <li><strong>Nombre de la Subcategoría:</strong> Nombre de la nueva subcategoría.</li>
                        <li><strong>Categoría:</strong> Seleccione la categoría a la que pertenece esta subcategoría.</li>
                    </ul>
                </div>

                <!-- Formulario de Adición -->
                <div class="card mt-3">

                    <div class="card-body">

                        <!-- Mensaje de éxito -->
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
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

                        <form action="{{ route('subcategoria.store') }}" method="POST">
                            @csrf

                            <!-- Nombre de la Subcategoría -->
                            <div class="form-group">
                                <label for="nombre_subcategoria">Nombre de la Subcategoría</label>
                                <input type="text" name="nombre_subcategoria" id="nombre_subcategoria" class="form-control" value="{{ old('nombre_subcategoria') }}" required>
                                @error('nombre_subcategoria')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Seleccionar Categoría -->
                            <div class="form-group">
                                <label for="cod_categoria">Categoría</label>
                                <select name="cod_categoria" id="cod_categoria" class="form-control" required>
                                    <option value="">Seleccione una Categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('cod_categoria') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre_categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cod_categoria')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

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
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Incluye el archivo JavaScript -->
<script src="{{ asset('assets/js/mensajes/mensajes.js') }}"></script>
@endsection
