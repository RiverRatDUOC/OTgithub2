@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
    @include('layouts.sidebar.dashboard')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <h2 class="mb-4">Detalle de la Línea</h2>

            <div class="card">
                <div class="card-header">
                    Línea: {{ $linea->nombre_linea }}
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $linea->nombre_linea }}</p>
                    <p><strong>Subcategoría:</strong> {{ $linea->subcategoria->nombre_subcategoria ?? 'Sin subcategoría' }}</p>

                    <!-- Botones -->
                    <a href="{{ route('parametros.index') }}" class="btn btn-primary" style="background-color: #cc6633;">Volver a la lista</a>
                    <a href="{{ route('lineas.edit', $linea->id) }}" class="btn btn-warning" style="background-color: #d39a7e;">Editar</a>
                </div>
            </div>
        </div>
    </main>
@endsection
