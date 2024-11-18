@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
    @include('layouts.sidebar.dashboard')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <!-- Detalle de la Sublínea -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h2>Detalle de la Sublínea</h2>
                <a href="{{ route('parametros.index') }}" class="btn btn-secondary" style="background-color: #cc6633; border-color: #cc6633;">
                    <i class="bi bi-arrow-left"></i> Regresar
                </a>
            </div>

            <!-- Información de la Sublínea -->
            <div class="card mt-3">
                <div class="card-header">
                    Sublínea: {{ $sublinea->nombre_sublinea }}
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $sublinea->nombre_sublinea }}</p>
                    <p><strong>Línea:</strong> {{ $sublinea->linea->nombre_linea ?? 'No asignada' }}</p>

                    <!-- Botones -->
                    <a href="{{ route('parametros.index') }}" class="btn btn-primary" style="background-color: #cc6633;">Volver a la lista</a>
                    <a href="{{ route('sublineas.edit', $sublinea->id) }}" class="btn btn-warning" style="background-color: #cc6633;">Editar</a>
                </div>
            </div>
        </div>
    </main>
@endsection
