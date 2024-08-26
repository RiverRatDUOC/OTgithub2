@extends('layouts.master')
@include('layouts.navbar.header')
@section('content')
    @include('layouts.sidebar.dashboard')

    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <main class="col py-3 flex-grow-1">
        <div class="container-fluid">
            <h3 class="mb-4">Home / Ordenes / Agregar</h3>
            <li class="nav-item {{ Request::is('ordenes/agregar') ? 'active' : '' }}">
                <a class="nav-link pl-0" href="{{ route('ordenes.create') }}">
                    <i class="fas fa-plus-circle"></i> <span>Agregar Orden</span>
                </a>
            </li>

            <div class="card">
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <select class="form-select form-control" id="cliente" name="cliente">
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre_cliente }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sucursal" class="form-label">Sucursal</label>
                            <input type="text" class="form-control" id="sucursal" name="sucursal">
                        </div>
                        <div class="mb-3">
                            <label for="servicio" class="form-label">Servicio</label>
                            <select class="form-select form-control" id="servicio" name="servicio">
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre_servicio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="responsable" class="form-label">Responsable</label>
                            <input type="text" class="form-control" id="responsable" name="responsable">
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select form-control" id="estado" name="estado">
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->descripcion_estado_ot }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="prioridad" class="form-label">Prioridad</label>
                            <select class="form-select form-control" id="prioridad" name="prioridad">
                                @foreach ($prioridades as $prioridad)
                                    <option value="{{ $prioridad->id }}">{{ $prioridad->descripcion_prioridad_ot }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de orden de trabajo</label>
                            <select class="form-select form-control" id="tipo" name="tipo">
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->descripcion_tipo_ot }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipoVisita" class="form-label">Tipo de visita</label>
                            <select class="form-select form-control" id="tipoVisita" name="tipoVisita">
                                @foreach ($tiposVisitas as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->descripcion_tipo_visita }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tecnicoEncargado" class="form-label">Técnico encargado</label>
                            <select class="form-select form-control" id="tecnicoEncargado" name="tecnicoEncargado">
                                @foreach ($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}">{{ $tecnico->nombre_tecnico }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                        <div class="mb-3">
                            <label for="cotizacion" class="form-label">Cotización</label>
                            <input type="text" class="form-control" id="cotizacion" name="cotizacion">
                        </div>

                        <button type="button" class="btn btn-primary" onclick="evento()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('assets/js/ordenes/crearOrden.js') }}"></script>
@endsection
