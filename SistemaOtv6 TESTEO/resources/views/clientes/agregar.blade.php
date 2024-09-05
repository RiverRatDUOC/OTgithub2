@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <h2 class="text-center mt-3">Agregar Cliente</h2>

        <!-- Sección Tutorial -->
        <div class="alert alert-info mt-4" role="alert">
            <h5 class="alert-heading">Tutorial</h5>
            <p>Agregue la siguiente información para agregar un cliente correctamente:</p>
            <ul>
                <li><strong>Nombre del Cliente:</strong> Nombre completo del cliente.</li>
                <li><strong>RUT:</strong> RUT del cliente (formato: xx.xxx.xxx-x).</li>
                <li><strong>Correo Electrónico:</strong> Correo electrónico de contacto.</li>
                <li><strong>Teléfono:</strong> Número de teléfono del cliente.</li>
                <li><strong>Sitio Web:</strong> Página web del cliente, si está disponible.</li>
            </ul>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf

                    <!-- Información del Cliente -->
                    <div class="form-group">
                        <label for="nombre_cliente">Nombre del Cliente</label>
                        <input type="text" class="form-control @error('nombre_cliente') is-invalid @enderror" id="nombre_cliente" name="nombre_cliente" value="{{ old('nombre_cliente') }}" required>
                        @error('nombre_cliente')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rut_cliente">RUT</label>
                        <input type="text" class="form-control @error('rut_cliente') is-invalid @enderror" id="rut_cliente" name="rut_cliente" value="{{ old('rut_cliente') }}" required>
                        @error('rut_cliente')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email_cliente">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email_cliente') is-invalid @enderror" id="email_cliente" name="email_cliente" value="{{ old('email_cliente') }}" required>
                        @error('email_cliente')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono_cliente">Teléfono</label>
                        <input type="text" class="form-control @error('telefono_cliente') is-invalid @enderror" id="telefono_cliente" name="telefono_cliente" value="{{ old('telefono_cliente') }}" required>
                        @error('telefono_cliente')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="web_cliente">Sitio Web</label>
                        <input type="text" class="form-control @error('web_cliente') is-invalid @enderror" id="web_cliente" name="web_cliente" value="{{ old('web_cliente') }}">
                        @error('web_cliente')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center mt-4">
                        <!-- Botón Guardar -->
                        <button type="submit" class="btn btn-primary me-auto" style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-save"></i> Guardar
                        </button>

                        <!-- Botón Cancelar -->
                        <a href="{{ route('clientes.index') }}" class="btn btn-secondary ms-auto">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection