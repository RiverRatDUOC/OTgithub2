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
                <p class="card-text"><strong>Nombre del Cliente:</strong> {{ $orden->contactoOt[0]->contacto->sucursal->cliente->nombre_cliente }}</p>
                <p class="card-text"><strong>Sucursal:</strong> {{ $orden->contactoOt[0]->contacto->sucursal->direccion_sucursal }}</p>
                <!-- Mostrando el primer contacto -->
                @if($orden->participantesContacto->isNotEmpty())
                <p class="card-text"><strong>Contacto:</strong> {{ $orden->participantesContacto->first()->contact_name }}</p>
                @else
                <p class="card-text"><strong>Contacto:</strong> N/A</p>
                @endif
                <p class="card-text"><strong>Tipo:</strong> {{ $orden->type }}</p>
                <p class="card-text"><strong>Estado:</strong> {{ $orden->status }}</p>
                <p class="card-text"><strong>Encargado:</strong> {{ $orden->leader }}</p>
                <p class="card-text"><strong>Encargado:</strong> {{ $orden->servicio->service_name }}</p>
                <!-- Mostrar técnicos participantes -->
                @if ($orden->participantes)
                <label for="participantes">Tecnicos:</label>
                <ul>
                    @foreach ($orden->participantes as $participante)
                    <li>{{ $participante->participant_name }}</li>
                    @endforeach
                </ul>
                @else
                <p>No hay participantes asociados a esta orden.</p>
                @endif


                <p class="card-text"><strong>Servicio:</strong> {{ $orden->servicio->service_name }}</p>
                <p class="card-text"><strong>Prioridad:</strong> {{ $orden->priority }}</p>




                <p class="card-text"><strong>Fecha:</strong> {{ $orden->created_at }}</p>
                <p class="card-text"><strong>Cotización:</strong> {{ $orden->cotizacion }}</p>
                <p class="card-text"><strong>Horas:</strong> {{ $orden->hours }}</p>

                <p class="card-text"><strong>Descripción:</strong> {{ $orden->description }}</p>
                <p class="card-text"><strong>Tipo de Visitas:</strong> {{ $orden->tipo_visitas }}</p>
                <p class="card-text"><strong>Número:</strong> {{ $orden->number }}</p>
                <p class="card-text"><strong>Comentario:</strong> {{ $orden->comment }}</p>



                <p class="card-text"><strong>Detalles:</strong> {{ $orden->detalle == 1 ? 'Si' : 'Se encuentra en perfecto estado' }}</p>


                <p class="card-text"><strong>Rayones:</strong> {{ $orden->rayones }}</p>
                <p class="card-text"><strong>El equipo posee Rupturas:</strong> {{ $orden->rupturas }}</p>
                <p class="card-text"><strong>El equipo posee los Tornillos de la carcasa:</strong> {{ $orden->tornillos }}</p>
                <p class="card-text"><strong>Gomas:</strong> {{ $orden->gomas }}</p>
                <p class="card-text"><strong>Estado del equipo:</strong> {{ $orden->estado }}</p>







                <p class="card-text"><strong>Observaciones adicionales:</strong> {{ $orden->observaciones }}</p>
                <p class="card-text"><strong>El equipo posee Accesorios:</strong> {{ $orden->accesorios == 1 ? 'Si' : 'No' }}</p>
                <p class="card-text"><strong>El equipo posee Cargador:</strong> {{ $orden->cargador }}</p>
                <p class="card-text"><strong>El equipo posee Cable de poder:</strong> {{ $orden->cable }}</p>
                <p class="card-text"><strong>El equipo posee Adaptador de poder:</strong> {{ $orden->adaptador }}</p>
                <p class="card-text"><strong>El equipo posee Batería:</strong> {{ $orden->bateria }}</p>
                <p class="card-text"><strong>El equipo posee Pantalla en mal estado:</strong> {{ $orden->pantalla }}</p>
                <p class="card-text"><strong>El equipo posee Teclado en mal estado:</strong> {{ $orden->teclado }}</p>
                <p class="card-text"><strong>El equipo posee Toner:</strong> {{ $orden->toner }}</p>
                <p class="card-text"><strong>El equipo posee Drum:</strong> {{ $orden->drum }}</p>

                <a href="{{ route('ordenes.index') }}" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </div>
</main>
@endsection