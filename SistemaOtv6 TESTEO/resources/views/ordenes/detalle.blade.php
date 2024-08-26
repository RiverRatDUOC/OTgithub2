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




                    <p class="card-text"><strong>Fecha:</strong> {{ $orden->created_at }}</p>
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
                            {{-- Aqui tengo que poner un if por si el dispositivo no tiene detalles --}}
                            @if ($dispositivo->detalles)
                                <p class="card-text"><strong>Detalles</strong></p>
                                <p class="card-text"><strong>Rayones:</strong>
                                    {{ $dispositivo->detalles->rayones_det }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Rupturas:</strong>
                                    {{ $dispositivo->detalles->rupturas_det }}
                                </p>
                                <p class="card-text"><strong>El equipo posee los Tornillos de la carcasa:</strong>
                                    {{ $dispositivo->detalles->tornillos_det }}
                                </p>
                                <p class="card-text"><strong>Gomas:</strong>
                                    {{ $dispositivo->detalles->gomas_det }}
                                </p>
                                <p class="card-text"><strong>Estado del equipo:</strong>
                                    {{ $dispositivo->detalles->estado_dispositivo_det }}
                                </p>
                                <p class="card-text"><strong>Observaciones adicionales:</strong>
                                    {{ $dispositivo->detalles->observaciones_det }}
                                </p>
                            @else
                                <p class="card-text"><strong>No existe información de detalles en este dispositivo</strong>
                                </p>
                            @endif

                            {{-- Aqui tengo que poner un if por si el dispositivo no tiene accesorios --}}
                            @if ($dispositivo->accesorios)
                                <p class="card-text"><strong>Accesorios</strong></p>
                                <p class="card-text"><strong>Cargador:</strong>
                                    {{ $dispositivo->accesorios->cargador_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Cargador:</strong>
                                    {{ $dispositivo->accesorios->cargador_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Cable de poder:</strong>
                                    {{ $dispositivo->accesorios->cable_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Adaptador de poder:</strong>
                                    {{ $dispositivo->accesorios->adaptador_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Batería:</strong>
                                    {{ $dispositivo->accesorios->bateria_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Pantalla en mal estado:</strong>
                                    {{ $dispositivo->accesorios->pantalla_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Teclado en mal estado:</strong>
                                    {{ $dispositivo->accesorios->teclado_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Drum:</strong>
                                    {{ $dispositivo->accesorios->drum_acc }}
                                </p>
                                <p class="card-text"><strong>El equipo posee Toner:</strong>
                                    {{ $dispositivo->accesorios->toner_acc }}
                                </p>
                            @else
                                <p class="card-text"><strong>No existe información de accesorios en este
                                        dispositivo</strong>
                                </p>
                            @endif

                            <hr>
                        @endforeach
                    @endif

                    <a href="{{ route('ordenes.index') }}" class="btn btn-primary">Volver</a>
                </div>
            </div>
        </div>
    </main>
@endsection
