@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Encabezado -->
                <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                    <h4>Datos de Parámetros</h4>
                </div>

                <!-- Sección: Categorías, Subcategorías, Líneas y Sublíneas -->
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #cc6633; color: white;">
                        <h5 class="mb-0">Categorías, Subcategorías, Líneas y Sublíneas</h5>
                    </div>
                    <div class="card-body">

                        <!-- Categorías -->
                        @include('parametros._partials.categorias')

                        <!-- Subcategorías -->
                        @include('parametros._partials.subcategorias')

                        <!-- Líneas -->
                        @include('parametros._partials.lineas')

                        <!-- Sublíneas -->
                        @include('parametros._partials.sublineas')

                <!-- Sección: Marcas -->
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #cc6633; color: white;">
                        <h5 class="mb-0">Marcas</h5>
                    </div>
                    <div class="card-body">
                        <!-- Marcas -->
                        @include('parametros._partials.marcas')

                        <!-- Modelos -->
                        @include('parametros._partials.modelos')


                        <!-- Tipos de Visita -->
                        @include('parametros._partials.tiposVisita')

                        <!-- Tipos de Servicio -->
                        @include('parametros._partials.tipoServicios')


                        <!-- Usuarios -->
                        @include('parametros._partials.usuarios')

                        <!-- Técnicos -->
                        @include('parametros._partials.tecnicos')

                        <!-- Clientes -->
                        @include('parametros._partials.clientes')

                        <!-- Sucursales -->
                        @include('parametros._partials.sucursales')

                        <!-- Contactos -->
                        @include('parametros._partials.contactos')

                        <!-- Servicios -->
                        @include('parametros._partials.servicios')

                        <!-- Técnico-Servicios -->
                        @include('parametros._partials.tecnicoServicios')

                        <!-- Tareas -->
                        @include('parametros._partials.tareas')

                        <!-- Dispositivos -->
                        @include('parametros._partials.dispositivos')

                        <!-- Estados de OT -->
                        @include('parametros._partials.estadosOt')

                        {{-- <!-- Dispositivos OT -->
                        @include('parametros._partials.dispositivosOt')

                        <!-- Tareas OT -->
                        @include('parametros._partials.tareasOt') --}}

                        {{-- <!-- Contactos OT -->
                        @include('parametros._partials.contactosOt') --}}

                        {{-- <!-- Equipos Técnicos -->
                        @include('parametros._partials.equiposTecnicos') --}}



                    </div>
                </div>
            </div>
</main>
@if(session('subcategoria_nombre') && session('categoria_nombre'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Subcategoría Creada',
            text: "La subcategoría '{{ session('subcategoria_nombre') }}' ha sido creada y asignada a la categoría'{{ session('categoria_nombre') }}' correctamente.",
            confirmButtonText: 'Aceptar'
        });
    </script>
@endif
@endsection
