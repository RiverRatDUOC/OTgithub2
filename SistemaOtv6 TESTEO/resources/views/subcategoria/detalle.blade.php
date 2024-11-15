@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
    @include('layouts.sidebar.dashboard')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- Detalle de la Subcategoría -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h2>Detalle de la Subcategoría</h2>
                        <a href="{{ route('parametros.index') }}" class="btn btn-secondary"
                            style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-arrow-left"></i> Regresar
                        </a>
                    </div>

                    <!-- Información de la Subcategoría -->
                    <div class="card mt-3">
                        <div class="card-header">
                            Subcategoría: {{ $subcategoria->nombre_subcategoria }}
                        </div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> {{ $subcategoria->nombre_subcategoria }}</p>
                            <p><strong>Categoría:</strong> {{ $subcategoria->categoria->nombre_categoria ?? 'Sin categoría' }}</p>
                            <a href="{{ route('parametros.index') }}" class="btn btn-primary"
                                style="background-color: #cc6633; border-color: #cc6633;">Volver a la lista</a>
                            <a href="{{ route('subcategoria.edit', $subcategoria->id) }}" class="btn btn-warning"
                                style="background-color: #d39a7e; border-color: #cc6633;">Editar</a>
                        </div>
                    </div>

                    <!-- Aquí puedes agregar más información relacionada si es necesario -->

                </div>
            </div>
        </div>
    </main>
@endsection
