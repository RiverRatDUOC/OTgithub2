@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
    @include('layouts.sidebar.dashboard')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- Detalle de la Categoría -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h2>Detalle de la Categoría</h2>
                        <a href="{{ route('parametros.index') }}" class="btn btn-secondary"
                            style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-arrow-left"></i> Regresar
                        </a>
                    </div>

                    <!-- Información de la Categoría -->
                    <div class="card mt-3">
                        <div class="card-header">
                            Categoría: {{ $categoria->nombre_categoria }}
                        </div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> {{ $categoria->nombre_categoria }}</p>
                            <a href="{{ route('parametros.index') }}" class="btn btn-primary"
                                style="background-color: #cc6633; border-color: #cc6633;">Volver a la lista</a>
                            <a href="{{ route('categoria.edit', $categoria->id) }}" class="btn btn-warning"
                                style="background-color: #d39a7e; border-color: #cc6633;">Editar</a>
                        </div>
                    </div>

                    <!-- Lista de Subcategorías -->
                    @if($categoria->subcategorias && $categoria->subcategorias->count() > 0)
                        <div class="card mt-3">
                            <div class="card-header">
                                <p><strong>Subcategoría(s): </strong>{{ $categoria->nombre_categoria }}</p>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($categoria->subcategorias as $subcategoria)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $subcategoria->nombre_subcategoria }}
                                            <div>
                                                <a href="{{ route('subcategoria.show', $subcategoria->id) }}" class="btn btn-sm btn-info" style="background-color: #cc6633; border-color: #cc6633;">Ver</a>
                                                <a href="{{ route('subcategoria.edit', $subcategoria->id) }}" class="btn btn-sm btn-warning" style="background-color: #d39a7e; border-color: #cc6633;">Editar</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            No hay subcategorías asignadas a esta categoría.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>
@endsection
