@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <h2 class="text-center mt-3">Agregar Sucursal</h2>

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

                    <!-- Opción para agregar un contacto -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="add_contact" name="add_contact">
                        <label class="form-check-label" for="add_contact">
                            Agregar un nuevo contacto
                        </label>
                    </div>

                    <!-- Información del Contacto (oculta inicialmente) -->
                    <div id="contact_fields" style="display: none;">
                        <div class="form-group mt-3">
                            <label for="nombre_contacto">Nombre del Contacto</label>
                            <input type="text" class="form-control @error('nombre_contacto') is-invalid @enderror" id="nombre_contacto" name="nombre_contacto" value="{{ old('nombre_contacto') }}">
                            @error('nombre_contacto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telefono_contacto">Teléfono del Contacto</label>
                            <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror" id="telefono_contacto" name="telefono_contacto" value="{{ old('telefono_contacto') }}">
                            @error('telefono_contacto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="departamento_contacto">Departamento del Contacto</label>
                            <input type="text" class="form-control @error('departamento_contacto') is-invalid @enderror" id="departamento_contacto" name="departamento_contacto" value="{{ old('departamento_contacto') }}">
                            @error('departamento_contacto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cargo_contacto">Cargo del Contacto</label>
                            <input type="text" class="form-control @error('cargo_contacto') is-invalid @enderror" id="cargo_contacto" name="cargo_contacto" value="{{ old('cargo_contacto') }}">
                            @error('cargo_contacto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email_contacto">Email del Contacto</label>
                            <input type="email" class="form-control @error('email_contacto') is-invalid @enderror" id="email_contacto" name="email_contacto" value="{{ old('email_contacto') }}">
                            @error('email_contacto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('add_contact').addEventListener('change', function() {
        document.getElementById('contact_fields').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection