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
                <!-- Agregar Línea -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Agregar Línea</h2>
                </div>

                <!-- Sección Tutorial -->
                <div class="alert alert-info mt-4" role="alert">
                    <h5 class="alert-heading">Tutorial</h5>
                    <p>Agregue la siguiente información para agregar una línea correctamente:</p>
                    <ul>
                        <li><strong>Nombre de la Línea:</strong> Nombre de la nueva línea.</li>
                        <li><strong>Subcategoría:</strong> Seleccione la subcategoría a la que pertenece.</li>
                    </ul>
                </div>

                <!-- Formulario de Adición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Agregar Información de la Línea
                    </div>
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

                        <form action="{{ route('lineas.store') }}" method="POST">
                            @csrf

                            <!-- Información de la Línea -->
                            <div class="form-group">
                                <label for="nombre_linea">Nombre de la Línea</label>
                                <input type="text" name="nombre_linea" id="nombre_linea" class="form-control" value="{{ old('nombre_linea') }}" required>
                                @error('nombre_linea')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Selección de Subcategoría -->
                            <div class="form-group">
                                <label for="cod_subcategoria">Subcategoría</label>
                                <select name="cod_subcategoria" id="cod_subcategoria" class="form-control" required>
                                    <option value="">Seleccione una subcategoría</option>
                                    @foreach ($subcategorias as $subcategoria)
                                    <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre_subcategoria }}</option>
                                    @endforeach
                                </select>
                                @error('cod_subcategoria')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <!-- Botón Guardar -->
                                <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">
                                    <i class="fas fa-save"></i> Guardar
                                </button>

                                <!-- Botón Cancelar -->
                                <a href="{{ route('parametros.index') }}" class="btn btn-secondary" style="background-color: #cc6633; border-color: #cc6633;">
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