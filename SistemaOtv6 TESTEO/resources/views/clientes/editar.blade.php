@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<link rel="stylesheet" href="{{ URL::to('assets/css/profile.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Editar Cliente -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Editar Cliente</h2>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-arrow-left"></i> Regresar
                    </a>
                </div>

                <!-- Formulario de Edición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Editar Información del Cliente
                    </div>
                    <div class="card-body">
                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre_cliente">Nombre</label>
                                <input type="text" name="nombre_cliente" id="nombre_cliente" class="form-control" value="{{ old('nombre_cliente', $cliente->nombre_cliente) }}" required>
                                @error('nombre_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="rut_cliente">RUT</label>
                                <input type="text" name="rut_cliente" id="rut_cliente" class="form-control" value="{{ old('rut_cliente', $cliente->rut_cliente) }}" required>
                                @error('rut_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email_cliente">Correo</label>
                                <input type="email" name="email_cliente" id="email_cliente" class="form-control" value="{{ old('email_cliente', $cliente->email_cliente) }}" required>
                                @error('email_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono_cliente">Teléfono</label>
                                <input type="text" name="telefono_cliente" id="telefono_cliente" class="form-control" value="{{ old('telefono_cliente', $cliente->telefono_cliente) }}" required>
                                @error('telefono_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="web_cliente">Sitio Web</label>
                                <input type="text" name="web_cliente" id="web_cliente" class="form-control" value="{{ old('web_cliente', $cliente->web_cliente) }}">
                                @error('web_cliente')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-times-circle"></i> Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection