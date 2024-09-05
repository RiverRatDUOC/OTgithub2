@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <h2 class="text-center mt-3">Agregar Sucursal</h2>
        <!-- Sección Tutorial -->
        <div class="alert alert-info mt-4" role="alert">
            <h5 class="alert-heading">Tutorial</h5>
            <p>Agregue la siguiente información para agregar una sucursal correctamente:</p>
            <ul>
                <li><strong>Sucursal:</strong> Nombre de la sucursal.</li>
                <li><strong>Teléfono:</strong> El teléfono de la sucursal.</li>
                <li><strong>Dirección:</strong> La dirección de la sucursal.</li>
                <li><strong>Cliente:</strong> Seleccione el cliente al que está ligado dicha sucursal. En caso de no tener el cliente creado previamente, haga clic <a href="{{ route('clientes.create') }}" class="font-weight-bold">aquí</a> para <strong>crear un nuevo cliente</strong>.</li>

            </ul>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('sucursales.store') }}" method="POST">
                    @csrf

                    <!-- Información de la Sucursal -->
                    <div class="form-group">
                        <label for="nombre_sucursal">Nombre de la Sucursal</label>
                        <input type="text" class="form-control @error('nombre_sucursal') is-invalid @enderror" id="nombre_sucursal" name="nombre_sucursal" value="{{ old('nombre_sucursal') }}" required>
                        @error('nombre_sucursal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono_sucursal">Teléfono</label>
                        <input type="text" class="form-control @error('telefono_sucursal') is-invalid @enderror" id="telefono_sucursal" name="telefono_sucursal" value="{{ old('telefono_sucursal') }}" required>
                        @error('telefono_sucursal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="direccion_sucursal">Dirección</label>
                        <input type="text" class="form-control @error('direccion_sucursal') is-invalid @enderror" id="direccion_sucursal" name="direccion_sucursal" value="{{ old('direccion_sucursal') }}" required>
                        @error('direccion_sucursal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cliente_id">Cliente</label>
                        <select class="form-control @error('cliente_id') is-invalid @enderror" id="cliente_id" name="cliente_id" required>
                            <option value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre_cliente }}
                            </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center mt-4">
                        <!-- Botón Guardar -->
                        <button type="submit" class="btn btn-primary me-auto" style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-save"></i> Guardar
                        </button>

                        <!-- Botón Cancelar -->
                        <a href="{{ route('sucursales.index') }}" class="btn btn-secondary ms-auto">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>


                </form>
            </div>
        </div>


    </div>
</main>
@endsection