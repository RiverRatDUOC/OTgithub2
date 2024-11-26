@extends('layouts.master')

@section('content')

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
                    <div class="card-header card-header-custom">
                        <h5 class="mb-0">Categorías, Subcategorías, Líneas y Sublíneas</h5>
                    </div>
                    <div class="card-body">

                        <!-- Categorías -->
                        @include('parametros._partials.categorias', ['categorias' => $categorias])

                        <!-- Subcategorías -->
                        @include('parametros._partials.subcategorias')

                        <!-- Líneas -->
                        @include('parametros._partials.lineas')

                        <!-- Sublíneas -->
                        @include('parametros._partials.sublineas')

                <!-- Sección: Marcas -->
                <div class="card mb-4">
                    <div class="card-header card-header-custom">
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

                        <!-- Contactos -->
                        @include('parametros._partials.contactos')

                        <!-- Sucursales -->
                        @include('parametros._partials.sucursales')

                        <!-- Servicios -->
                        @include('parametros._partials.servicios')

                        {{-- <!-- Técnico-Servicios -->
                        @include('parametros._partials.tecnicoServicios') --}}

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

@endsection

@section('scripts')
    <!-- Scripts de SweetAlert para Creaciones -->
    @if(session('categoria_nombre'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Categoría Creada',
                text: "La categoría '{{ session('categoria_nombre') }}' ha sido creada correctamente.",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if(session('subcategoria_nombre') && session('categoria_nombre'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Subcategoría Creada',
                text: "La subcategoría '{{ session('subcategoria_nombre') }}' ha sido creada y asignada a la categoría '{{ session('categoria_nombre') }}' correctamente.",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if(session('linea_nombre') && session('subcategoria_nombre'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Línea Creada',
                text: "La línea '{{ session('linea_nombre') }}' ha sido creada y asignada a la subcategoría '{{ session('subcategoria_nombre') }}' correctamente.",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if(session('sublinea_nombre') && session('linea_nombre'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sublínea Creada',
                text: "La sublínea '{{ session('sublinea_nombre') }}' ha sido creada y asignada a la línea '{{ session('linea_nombre') }}' correctamente.",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    <!-- Scripts de SweetAlert para Eliminaciones -->
    @if(session('categoria_deleted'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Categoría Eliminada',
                text: "La categoría '{{ session('categoria_deleted') }}' ha sido eliminada correctamente.",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if(session('subcategoria_deleted'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Subcategoría Eliminada',
                text: "La subcategoría '{{ session('subcategoria_deleted') }}' ha sido eliminada correctamente.",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if(session('linea_deleted'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Línea Eliminada',
                text: "La línea '{{ session('linea_deleted') }}' ha sido eliminada correctamente.",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    @if(session('delete_error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('delete_error') }}",
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif

    <!-- Script para Confirmación de Eliminación -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Confirmación de Eliminación
            $(document).on('submit', '.delete-form', function(e) {
                e.preventDefault(); // Prevenir el envío inmediato del formulario
                let form = this; // Referencia al formulario actual

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviar el formulario si se confirma
                    }
                })
            });
        });
    </script>
@endsection
