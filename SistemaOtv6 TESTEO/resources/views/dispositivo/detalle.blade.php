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
                <!-- Detalle del Dispositivo -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Detalle del Dispositivo</h2>
                    <a href="{{ route('dispositivos.index') }}" class="btn btn-secondary" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-arrow-left"></i> Volver a la lista
                    </a>
                </div>

                <!-- Información del Dispositivo -->
                <div class="card mt-3">
                    <div class="card-header">
                        Información del Dispositivo
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Número de Serie</th>
                                    <th>Modelo</th>
                                    <th>Sucursal</th>
                                    <th>Creado en</th>
                                    <th>Actualizado en</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $dispositivo->numero_serie_dispositivo }}</td>
                                    <td>{{ $dispositivo->modelo->nombre_modelo }}</td>
                                    <td>{{ $dispositivo->sucursal->nombre_sucursal }}</td>
                                    <td>{{ $dispositivo->created_at }}</td>
                                    <td>{{ $dispositivo->updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection