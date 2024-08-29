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
                            <div class="col-md-12 block-relieve m-2" id="bloque">
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
                                        <ul class="list-group" id="tareas">
                                        </ul>
                                        {{-- <select id="tareas" class="form-control" multiple>
                                            <option value="">Seleccione una tarea</option>
                                            <!-- opciones de tareas -->
                                        </select> --}}
                                    </div>
                                    <div class="d-flex justify-content-between col-11 mt-3">
                                        <div class="row col-12">
                                            <div class="col-md-6">
                                                <div id="detallesDispositivo" style="display: none;">
                                                    <input type="text" class="detalleSiNo" id="detalleSiNo" hidden>
                                                    <div class="m-2">
                                                        <label for="rayones">¿El Equipo Posee Rayones?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="rayones" id="rayonesSi" value="Mostrar">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="rayones" id="rayonesNo" value="NoMostrar">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="rayonesTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="detallesRayones" id="detallesRayones"
                                                                placeholder="El equipo presenta..." style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="rupturas">¿El Equipo Posee Rupturas?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="rupturas" id="rupturasSi" value="Mostrar">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="rupturas" id="rupturasNo" value="NoMostrar">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="rupturasTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="detallesRupturas" id="detallesRupturas"
                                                                placeholder="El equipo presenta..." style="display:none">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="tornillos">¿El Equipo Posee Todos Los Tornillos De Su
                                                            Carcasa?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="tornillos" id="tornillosSi" value="NoMostrar">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="tornillos" id="tornillosNo" value="Mostrar">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="tornillosTexto">
                                                            <input class="form-control" type="text"
                                                                name="detallesTornillos" id="detallesTornillos"
                                                                placeholder="El equipo presenta..." style="display: none">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="gomas">¿El Equipo Posee Las Gomas De La Base En Buen
                                                            Estado?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="gomas" id="gomasSi" value="NoMostrar">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="gomas" id="gomasNo" value="Mostrar">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="gomasTexto">
                                                            <input class="form-control" type="text"
                                                                name="detallesGomas" id="detallesGomas"
                                                                placeholder="El equipo presenta..." style="display: none">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="estado">Estado del equipo</label>
                                                        <input type="text" class="form-control" id="estado"
                                                            name="estado">
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="observacion">Observaciones adicionales</label>
                                                        <input type="text" class="form-control" id="observacion"
                                                            name="observacion">
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" id="botonAgregarDetalle" type="button"
                                                    style="font-size:14px" onclick="mostrarDetalles()">Agregar
                                                    detalles</button>
                                                <input type="hidden" name="bloqueNumero" value="-1"
                                                    class="bloqueNumero">
                                                <button class="btn btn-danger botonCancelarDetalle"
                                                    id="botonCancelarDetalle" type="button"
                                                    style="font-size:14px; display:none">Cancelar</button>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="accesoriosDispositivo" style="display: none;">
                                                    <input type="text" value="0" id="accesorioSiNo" hidden>

                                                    <div class="m-2">
                                                        <label for="cargador">¿El Equipo Posee Cargador?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="cargador" id="cargadorSi" value="MostrarCB">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="cargador" id="cargadorNo" value="NoMostrarCB">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="cargadorTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosCargador" id="accesoriosCargador"
                                                                placeholder="El equipo presenta..." style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="cable">¿El Equipo Posee Cable de Poder?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="cable" id="cableSi" value="MostrarCA">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="cable" id="cableNo" value="NoMostrarCA">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="cableTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosCable" id="accesoriosCable"
                                                                placeholder="Ingrese observaciones" style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="adaptador">¿El Equipo Posee Adaptador de Poder?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="adaptador" id="adaptadorSi" value="MostrarCA">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="adaptador" id="adaptadorNo"
                                                                    value="NoMostrarCA">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="adaptadorTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosAdaptador" id="accesoriosAdaptador"
                                                                placeholder="Ingrese observaciones" style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="bateria">¿El Equipo Posee Batería?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="bateria" id="bateriaSi" value="MostrarCB">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="bateria" id="bateriaNo" value="NoMostrarCB">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="bateriaTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosBateria" id="accesoriosBateria"
                                                                placeholder="El equipo presenta..." style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="pantalla">¿El Equipo Posee Pantalla En Mal
                                                            Estado?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="pantalla" id="pantallaSi" value="MostrarPT">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="pantalla" id="pantallaNo" value="NoMostrarPT">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="pantallaTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosPantalla" id="accesoriosPantalla"
                                                                placeholder="El equipo presenta..." style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="teclado">¿El Equipo Posee Teclado en Mal
                                                            Estado?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="teclado" id="tecladoSi" value="MostrarPT">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="teclado" id="tecladoNo" value="NoMostrarPT">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="tecladoTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosTeclado" id="accesoriosTeclado"
                                                                placeholder="El equipo presenta..." style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="drum">¿El Equipo Posee Toner?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="drum" id="drumSi" value="NoMostrarTD">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="drum" id="drumNo" value="MostrarTD">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="drumTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosDrum" id="accesoriosDrum"
                                                                placeholder="El equipo presenta..." style="display:none;">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="m-2">
                                                        <label for="toner">¿El Equipo Posee Drum?</label>
                                                        <div class="form-check">
                                                            <label>
                                                                <input class="form-check-input" type="radio"
                                                                    name="toner" id="tonerSi" value="NoMostrarTD">
                                                                Si</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label>

                                                                <input class="form-check-input" type="radio"
                                                                    name="toner" id="tonerNo" value="MostrarTD">
                                                                No</label>
                                                        </div>
                                                        <div class="form-check textoInf" id="tonerTexto">
                                                            <input class="form-control textoInf" type="text"
                                                                name="accesoriosToner" id="accesoriosToner"
                                                                placeholder="El equipo presenta..." style="display:none;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" id="botonAgregarAccesorio"
                                                    style="font-size:14px" type="button"
                                                    onclick="mostrarAccesorios()">Agregar
                                                    accesorios
                                                </button>
                                                <button class="btn btn-danger" id="botonCancelarAccesorio" type="button"
                                                    style="font-size:14px; display:none"
                                                    onclick="cancelarAccesorios()">Cancelar
                                                </button>

                                            </div>

                                        </div>

                                    </div>
                                    <button class="btn btn-primary btn-add boton-inferior-derecha"
                                        type="button">+</button>
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
