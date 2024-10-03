@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Técnico</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $tecnico->nombre_tecnico }}</h3>
            <p><strong>RUT:</strong> {{ $tecnico->rut_tecnico }}</p>
            <p><strong>Teléfono:</strong> {{ $tecnico->telefono_tecnico }}</p>
            <p><strong>Email:</strong> {{ $tecnico->email_tecnico }}</p>
            <p><strong>Precio por Hora:</strong> {{ $tecnico->precio_hora_tecnico }}</p>
            <!-- Puedes agregar más detalles según tus necesidades -->
        </div>
    </div>

    <a href="{{ route('tecnicos.index') }}" class="btn btn-primary mt-3">Volver a la lista</a>
</div>
@endsection