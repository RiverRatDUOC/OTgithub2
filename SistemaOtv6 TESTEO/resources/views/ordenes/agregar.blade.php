@extends('layouts.master')
@include('layouts.navbar.header')
@section('content')
@include('layouts.sidebar.dashboard')

<link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

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
                        <input type="text" class="form-control" id="cliente" name="cliente">
                    </div>
                    <div class="mb-3">
                        <label for="sucursal" class="form-label">Sucursal</label>
                        <input type="text" class="form-control" id="sucursal" name="sucursal">
                    </div>
                    <div class="mb-3">
                        <label for="servicio" class="form-label">Servicio</label>
                        <input type="text" class="form-control" id="servicio" name="servicio">
                    </div>
                    <div class="mb-3">
                        <label for="responsable" class="form-label">Responsable</label>
                        <input type="text" class="form-control" id="responsable" name="responsable">
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="iniciada">Iniciada</option>
                            <option value="finalizada">Finalizada</option>
                            <option value="pendiente">Pendiente</option>
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

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</main>

@endsection