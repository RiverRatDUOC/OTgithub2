@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
    @include('layouts.sidebar.dashboard')

    <main class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <h2 class="text-center mt-3">Detalle de la Orden</h2>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Orden #{{ $orden->numero_ot }}</h5>
                    <p class="card-text"><strong>Nombre del Cliente:</strong>
                        @if (count($orden->contactoOt) != 0)
                            {{ $orden->contactoOt[0]->contacto->sucursal->cliente->nombre_cliente }}
                        @else
                            {{ $orden->contacto->sucursal->cliente->nombre_cliente }}
                        @endif
                    </p>
                    <p class="card-text"><strong>Sucursal:</strong>
                        @if (count($orden->contactoOt) != 0)
                            {{ $orden->contactoOt[0]->contacto->sucursal->direccion_sucursal }}
                        @else
                            {{ $orden->contacto->sucursal->direccion_sucursal }}
                        @endif

                    </p>
                    <!-- Mostrando el primer contacto -->
                    <p class="card-text"><strong>Contacto:</strong>
                        @if (count($orden->contactoOt) != 0)
                            {{ $orden->contactoOt[0]->contacto->nombre_contacto }}
                        @else
                            {{ $orden->contacto->nombre_contacto }}
                        @endif
                    </p>

                    <p class="card-text"><strong>Tipo:</strong> {{ $orden->tipo->descripcion_tipo_ot }}</p>
                    <p class="card-text"><strong>Estado:</strong> {{ $orden->estado->descripcion_estado_ot }}</p>
                    <p class="card-text"><strong>Encargado:</strong> {{ $orden->tecnicoEncargado->nombre_tecnico }}</p>
                    <!-- Mostrar técnicos participantes -->
                    @if ($orden->EquipoTecnico)
                        <label for="participantes">Tecnicos:</label>
                        <ul>
                            @foreach ($orden->EquipoTecnico as $EquipoTecnico)
                                <li>{{ $EquipoTecnico->tecnico->nombre_tecnico }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No hay participantes asociados a esta orden.</p>
                    @endif


                    <p class="card-text"><strong>Servicio:</strong> {{ $orden->servicio->nombre_servicio }}</p>
                    <p class="card-text"><strong>Prioridad:</strong> {{ $orden->prioridad->descripcion_prioridad_ot }}
                    </p>
                    <p class="card-text"><strong>Fecha de creación de orden de trabajo:</strong>
                        {{ date('d-m-Y', strtotime($orden->created_at)) }}</p>
                    <p class="card-text"><strong>Fecha de inicio de orden de trabajo:</strong>
                        {{ date('d-m-Y', strtotime($orden->fecha_inicio_planificada_ot)) }}</p>
                    <p class="card-text"><strong>Fecha estimada de finalización:</strong>
                        {{ date('d-m-Y', strtotime($orden->fecha_fin_planificada_ot)) }}</p>
                    <p class="card-text"><strong>Cotización:</strong> {{ $orden->cotizacion }}</p>
                    <p class="card-text"><strong>Horas:</strong> {{ $orden->horas_ot }}</p>

                    <p class="card-text"><strong>Descripción:</strong> {{ $orden->descripcion_ot }}</p>
                    <p class="card-text"><strong>Tipo de Visitas:</strong>
                        {{ $orden->tipoVisita->descripcion_tipo_visita }}</p>
                    <p class="card-text"><strong>Comentario:</strong>
                        @if ($orden->comentario_ot == null)
                            Sin comentario.
                        @else
                            {{ $orden->comentario_ot }}
                        @endif
                    </p>

                    @if ($orden->servicio->cod_tipo_servicio == 1)
                        <div class="accordion my-3" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Tareas
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Tarea</th>
                                                    <th scope="col">Tiempo duración (Minutos)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orden->TareasOt as $tarea)
                                                    <tr>
                                                        <td>{{ html_entity_decode($tarea->tarea->nombre_tarea) }}</td>
                                                        <td>{{ $tarea->tarea->tiempo_tarea }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @else
                        <div>
                            @if (count($orden->DispositivoOT) != 0)
                                @foreach ($orden->DispositivoOT as $dispositivo)
                                    <hr>
                                    <p class="card-text"><strong>Dispositivo</strong></p>
                                    <p class="card-text"><strong>Número de serie:</strong>
                                        {{ $dispositivo->dispositivo->numero_serie_dispositivo }}
                                    </p>
                                    <p class="card-text"><strong>Modelo:</strong>
                                        {{ $dispositivo->dispositivo->modelo->nombre_modelo }}
                                    </p>
                                    <p class="card-text"><strong>Marca:</strong>
                                        {{ $dispositivo->dispositivo->modelo->marca->nombre_marca }}
                                    </p>
                                    <div class="accordion my-3" id="accordionExample{{ $loop->iteration }}">
                                        <div class="card">
                                            <div class="card-header" id="heading{{ $loop->iteration }}">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                        data-toggle="collapse"
                                                        data-target="#collapse{{ $loop->iteration }}" aria-expanded="false"
                                                        aria-controls="collapse{{ $loop->iteration }}">
                                                        Tareas
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapse{{ $loop->iteration }}" class="collapse"
                                                aria-labelledby="heading{{ $loop->iteration }}"
                                                data-parent="#accordionExample{{ $loop->iteration }}">
                                                <div class="card-body">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Tarea</th>
                                                                <th scope="col">Tiempo duración (Minutos)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($dispositivo->tareaDispositivo as $tarea)
                                                                <tr>
                                                                    <td>{{ html_entity_decode($tarea->tarea->nombre_tarea) }}
                                                                    </td>
                                                                    <td>{{ $tarea->tarea->tiempo_tarea }}</td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    @if ($dispositivo->detalles)
                                        <div class="accordion my-3" id="accordionExampleD{{ $loop->iteration }}">
                                            <div class="card">
                                                <div class="card-header" id="headingD{{ $loop->iteration }}">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#collapseD{{ $loop->iteration }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapseD{{ $loop->iteration }}">
                                                            Detalles
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapseD{{ $loop->iteration }}" class="collapse"
                                                    aria-labelledby="headingD{{ $loop->iteration }}"
                                                    data-parent="#accordionExampleD{{ $loop->iteration }}">
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Detalle</th>
                                                                    <th scope="col">Descripción</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Rayones</td>
                                                                    <td>{{ $dispositivo->detalles->rayones_det }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Rupturas</td>
                                                                    <td>{{ $dispositivo->detalles->rupturas_det }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tornillos</td>
                                                                    <td>{{ $dispositivo->detalles->tornillos_det }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Gomas</td>
                                                                    <td>{{ $dispositivo->detalles->gomas_det }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Estado del equipo</td>
                                                                    <td>{{ $dispositivo->detalles->estado_dispositivo_det }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Observaciones adicionales</td>
                                                                    <td>{{ $dispositivo->detalles->observaciones_det }}
                                                                    </td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @else
                                        <p class="card-text"><strong>No existe información de detalles en este
                                                dispositivo</strong>
                                        </p>
                                    @endif

                                    @if ($dispositivo->accesorios)
                                        <div class="accordion my-3" id="accordionExampleA{{ $loop->iteration }}">
                                            <div class="card">
                                                <div class="card-header" id="headingA{{ $loop->iteration }}">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#collapseA{{ $loop->iteration }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapseA{{ $loop->iteration }}">
                                                            Accesorios
                                                        </button>
                                                    </h2>
                                                </div>

                                                <div id="collapseA{{ $loop->iteration }}" class="collapse"
                                                    aria-labelledby="headingA{{ $loop->iteration }}"
                                                    data-parent="#accordionExampleA{{ $loop->iteration }}">
                                                    <div class="card-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Accesorios</th>
                                                                    <th scope="col">Descripción</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Cargador</td>
                                                                    <td>{{ $dispositivo->accesorios->cargador_acc }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cable de poder</td>
                                                                    <td>{{ $dispositivo->accesorios->cable_acc }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Adaptador de poder</td>
                                                                    <td>{{ $dispositivo->accesorios->adaptador_acc }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Batería</td>
                                                                    <td>{{ $dispositivo->accesorios->bateria_acc }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pantalla en mal estado</td>
                                                                    <td>{{ $dispositivo->accesorios->pantalla_acc }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Teclado en mal estado</td>
                                                                    <td>{{ $dispositivo->accesorios->teclado_acc }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Drum</td>
                                                                    <td>{{ $dispositivo->accesorios->drum_acc }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Toner</td>
                                                                    <td>{{ $dispositivo->accesorios->toner_acc }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @else
                                        <p class="card-text"><strong>No existe información de accesorios en este
                                                dispositivo</strong>
                                        </p>
                                    @endif

                                    <hr>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    <a href="{{ route('ordenes.index') }}" class="btn btn-primary">Volver</a>
                </div>
            </div>
        </div>
    </main>
@endsection
