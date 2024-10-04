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
                    <!-- Detalle del Técnico -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h2>Detalle del Técnico</h2>
                        <a href="{{ route('tecnicos.index') }}" class="btn btn-secondary"
                            style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-arrow-left"></i> Regresar
                        </a>
                    </div>

                    <!-- Información del Técnico -->
                    <div class="card mt-3">
                        <div class="card-header">
                            Información del Técnico
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>RUT</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Precio por Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $tecnico->nombre_tecnico }}</td>
                                        <td>{{ $tecnico->rut_tecnico }}</td>
                                        <td>{{ $tecnico->telefono_tecnico }}</td>
                                        <td>{{ $tecnico->email_tecnico }}</td>
                                        <td>${{ number_format($tecnico->precio_hora_tecnico, 2, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Información del Usuario Asociado -->
                    @if ($tecnico->usuario)
                        <div class="card mt-3">
                            <div class="card-header">
                                Información del Usuario Asociado
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre de Usuario</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $tecnico->usuario->nombre_usuario }}</td>
                                            <td>{{ $tecnico->usuario->email_usuario }}</td>
                                            <td>{{ $tecnico->usuario->rol_usuario }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="card mt-3">
                            <div class="card-header">
                                Información del Usuario Asociado
                            </div>
                            <div class="card-body">
                                <p>No hay usuario asociado.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
