@extends('layouts.master')

@section('content')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Detalle del Servicio -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Detalle del Servicio</h2>
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary"
                        style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-arrow-left"></i> Regresar
                    </a>
                </div>

                <!-- Información del Servicio -->
                <div class="card mt-3">
                    <div class="card-header">
                        Información del Servicio
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre del Servicio</th>
                                    <th>Código Tipo de Servicio</th>
                                    <th>Código Sublinea</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $servicio->nombre_servicio }}</td>
                                    <td>{{ $servicio->cod_tipo_servicio }}</td>
                                    <td>{{ $servicio->cod_sublinea }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Información de las Tareas Asociadas -->
                @if ($servicio->tareas->count() > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        Información de las Tareas Asociadas
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre de la Tarea</th>
                                    <th>Tiempo de la Tarea</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicio->tareas as $tarea)
                                <tr>
                                    <td>{{ $tarea->nombre_tarea }}</td>
                                    <td>{{ $tarea->tiempo_tarea }} horas</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card mt-3">
                    <div class="card-header">
                        Información de las Tareas Asociadas
                    </div>
                    <div class="card-body">
                        <p>No hay tareas asociadas a este servicio.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
