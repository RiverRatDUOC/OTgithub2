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
                <!-- Detalle del Contacto -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Detalle del Contacto</h2>
                    <a href="{{ route('contactos.index') }}" class="btn btn-secondary" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-arrow-left"></i> Regresar
                    </a>
                </div>

                <!-- Información del Contacto -->
                <div class="card mt-3">
                    <div class="card-header">
                        Información del Contacto
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Departamento</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                    <th>Sucursal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $contacto->nombre_contacto ?? 'No disponible' }}</td>
                                    <td>{{ $contacto->telefono_contacto ?? 'No disponible' }}</td>
                                    <td>{{ $contacto->departamento_contacto ?? 'No disponible' }}</td>
                                    <td>{{ $contacto->cargo_contacto ?? 'No disponible' }}</td>
                                    <td>{{ $contacto->email_contacto ?? 'No disponible' }}</td>
                                    <td>{{ $contacto->sucursal->nombre_sucursal ?? 'No disponible' }}</td> <!-- Suponiendo que hay una relación 'sucursal' -->
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