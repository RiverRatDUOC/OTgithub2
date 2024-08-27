@extends('layouts.master')
@include('layouts.navbar.header')
@section('content')
    @include('layouts.sidebar.dashboard')

    <link rel="stylesheet" href="{{ asset('assets/css/ordenes.css') }}">

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
                                <option value="0">Seleccione un cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre_cliente }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="sucursal" class="form-label">Sucursal</label>

                            <select class="form-select form-control" id="sucursal" name="sucursal">
                                <option value="0">Seleccione una sucursal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="contacto" class="form-label">Contacto</label>
                            <select class="form-select form-control" id="contacto" name="contacto">
                                <option value="0">Seleccione un contacto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="servicio" class="form-label">Servicio</label>
                            <select class="form-select form-control" id="servicio" name="servicio">
                                <option value="0">Seleccione un servicio</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre_servicio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="tipoServicio" id="tipoServicio" value="" hidden>
                        {{-- <div class="mb-3">
                            <label for="dispositivo" class="form-label">Dispositivo(s)</label>
                            <select class="form-select form-control" id="dispositivo" name="dispositivo">
                                <option value="0">Seleccione un dispositivo</option>
                            </select>
                        </div> --}}
                        {{-- Bloque para los dispositivos de la OT  --}}
                        <div class="row" id="bloqueDispositivos" style="display:none;">
                            <div class="col-md-12 block-relieve m-2">
                                <div class="block-content">
                                    <div class="form-group col-12">
                                        <label for="dispositivo">Dispositivo:</label>
                                        <select id="dispositivo" class="form-control">
                                            <option value="">Seleccione un dispositivo</option>
                                            <!-- opciones de dispositivo -->
                                        </select>
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="tareas">Tareas:</label>
                                        <select id="tareas" class="form-control" multiple>
                                            <option value="">Seleccione una tarea</option>
                                            <!-- opciones de tareas -->
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between col-10 mt-3">
                                        <button class="btn btn-primary mr-5">Agregar detalles del equipo</button>
                                        <button class="btn btn-primary">Agregar accesorios del equipo</button>
                                    </div>
                                    <button class="btn btn-primary btn-add boton-inferior-derecha" type="button">+</button>
                                </div>
                            </div>
                        </div>
                        {{-- Bloque para tareas para la Ot --}}
                        <div id="bloqueTareas" class="card col-md-5" style="display:none;">
                            <div class="form-group  p-4">
                                <label for="tareasSinDispositivo">Tareas:</label>
                                <ul class="list-group" id="tareasSinDispositivo">
                                </ul>
                                {{-- <div id="tareasSinDispositivo"></div>
                                <select id="tareasSinDispositivo" class="form-control" multiple>
                                    <option value="">Seleccione una tarea</option>
                                    <!-- Agrega opciones de tareas aquí -->
                                </select> --}}
                            </div>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="tareas" class="form-label">Tareas</label>
                            <select class="form-select form-control" id="tareas" name="tareas">
                                <option value="0">Seleccione una tarea</option>
                            </select>
                        </div> --}}
                        <div class="mb-3">
                            <label for="tecnicoEncargado" class="form-label">Técnico encargado</label>
                            <select class="form-select form-control" id="tecnicoEncargado" name="tecnicoEncargado">
                                <option value="0">Seleccione un técnico</option>
                                @foreach ($tecnicos as $tecnico)
                                    <option value="{{ $tecnico->id }}">{{ $tecnico->nombre_tecnico }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select form-control" id="estado" name="estado">
                                <option value="0">Seleccione un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->descripcion_estado_ot }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="prioridad" class="form-label">Prioridad</label>
                            <select class="form-select form-control" id="prioridad" name="prioridad">
                                <option value="0">Seleccione una prioridad</option>
                                @foreach ($prioridades as $prioridad)
                                    <option value="{{ $prioridad->id }}">{{ $prioridad->descripcion_prioridad_ot }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de orden de trabajo</label>
                            <select class="form-select form-control" id="tipo" name="tipo">
                                <option value="0">Seleccione un tipo de orden de trabajo</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->descripcion_tipo_ot }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipoVisita" class="form-label">Tipo de visita</label>
                            <select class="form-select form-control" id="tipoVisita" name="tipoVisita">
                                <option value="0">Seleccione un tipo de visita</option>
                                @foreach ($tiposVisitas as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->descripcion_tipo_visita }}</option>
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
