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
                <!-- Editar Contacto -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Editar Contacto</h2>
                    <a href="{{ route('contactos.index') }}" class="btn btn-secondary" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-arrow-left"></i> Regresar
                    </a>
                </div>

                <!-- Formulario de Edición -->
                <div class="card mt-3">
                    <div class="card-header">
                        Editar Información del Contacto
                    </div>
                    <div class="card-body">
                        <form action="{{ route('contactos.update', $contacto->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre_contacto">Nombre</label>
                                <input type="text" name="nombre_contacto" id="nombre_contacto" class="form-control @error('nombre_contacto') is-invalid @enderror" value="{{ old('nombre_contacto', $contacto->nombre_contacto) }}" required>
                                @error('nombre_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono_contacto">Teléfono</label>
                                <input type="text" name="telefono_contacto" id="telefono_contacto" class="form-control @error('telefono_contacto') is-invalid @enderror" value="{{ old('telefono_contacto', $contacto->telefono_contacto) }}" required>
                                @error('telefono_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="departamento_contacto">Departamento</label>
                                <input type="text" name="departamento_contacto" id="departamento_contacto" class="form-control @error('departamento_contacto') is-invalid @enderror" value="{{ old('departamento_contacto', $contacto->departamento_contacto) }}">
                                @error('departamento_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cargo_contacto">Cargo</label>
                                <input type="text" name="cargo_contacto" id="cargo_contacto" class="form-control @error('cargo_contacto') is-invalid @enderror" value="{{ old('cargo_contacto', $contacto->cargo_contacto) }}">
                                @error('cargo_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email_contacto">Correo Electrónico</label>
                                <input type="email" name="email_contacto" id="email_contacto" class="form-control @error('email_contacto') is-invalid @enderror" value="{{ old('email_contacto', $contacto->email_contacto) }}" required>
                                @error('email_contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cod_sucursal">Sucursal</label>
                                <select name="cod_sucursal" id="cod_sucursal" class="form-control @error('cod_sucursal') is-invalid @enderror" required>
                                    @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ $contacto->cod_sucursal == $sucursal->id ? 'selected' : '' }}>
                                        {{ $sucursal->nombre_sucursal }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('cod_sucursal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="submit" class="btn btn-primary" style="background-color: #cc0066; border-color: #cc0066;">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('contactos.index') }}" class="btn btn-secondary" style="background-color: #cc0066; border-color: #cc0066;">
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