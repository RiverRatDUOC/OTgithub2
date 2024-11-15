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

                        <!-- Estados de OT -->
                        @include('parametros._partials.estadosOt')

                        <!-- Tipos de Visita -->
                        @include('parametros._partials.tiposVisita')
                        
                        <!-- Tipos de Servicio -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Tipos de Servicio</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tipos_servicio as $tipo_servicio)
                                        <tr>
                                            <td>{{ $tipo_servicio->id }}</td>
                                            <td>{{ $tipo_servicio->descripcion_tipo_servicio }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Modelos -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Modelos</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Descripción Corta</th>
                                            <th>Descripción Larga</th>
                                            <th>Part Number</th>
                                            <th>Marca</th>
                                            <th>Sublínea</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modelos as $modelo)
                                        <tr>
                                            <td>{{ $modelo->id }}</td>
                                            <td>{{ $modelo->nombre_modelo }}</td>
                                            <td>{{ $modelo->desc_corta_modelo }}</td>
                                            <td>{{ $modelo->desc_larga_modelo }}</td>
                                            <td>{{ $modelo->part_number_modelo }}</td>
                                            <td>{{ $modelo->marca->nombre_marca ?? 'No asignada' }}</td>
                                            <td>{{ $modelo->sublinea->nombre_sublinea ?? 'No asignada' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>

    @include('parametros._partials.usuarios')
                        <!-- Usuarios -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Usuarios</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Email Verificado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td>{{ $usuario->id }}</td>
                                            <td>{{ $usuario->nombre_usuario }}</td>
                                            <td>{{ $usuario->email_usuario }}</td>
                                            <td>{{ $usuario->rol_usuario }}</td>
                                            <td>{{ $usuario->email_verified_at ? $usuario->email_verified_at->format('Y-m-d H:i:s') : 'No' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Técnicos -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Técnicos</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>RUT</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Precio por Hora</th>
                                            <th>Usuario Asociado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tecnicos as $tecnico)
                                        <tr>
                                            <td>{{ $tecnico->id }}</td>
                                            <td>{{ $tecnico->nombre_tecnico }}</td>
                                            <td>{{ $tecnico->rut_tecnico }}</td>
                                            <td>{{ $tecnico->telefono_tecnico }}</td>
                                            <td>{{ $tecnico->email_tecnico }}</td>
                                            <td>${{ number_format($tecnico->precio_hora_tecnico) }}</td>
                                            <td>{{ $tecnico->usuario->nombre_usuario ?? 'No asignado' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Clientes -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Clientes</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>RUT</th>
                                            <th>Web</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ $cliente->id }}</td>
                                            <td>{{ $cliente->nombre_cliente }}</td>
                                            <td>{{ $cliente->rut_cliente }}</td>
                                            <td>{{ $cliente->web_cliente }}</td>
                                            <td>{{ $cliente->telefono_cliente }}</td>
                                            <td>{{ $cliente->email_cliente }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>

                        <!-- Sucursales -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Sucursales</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Dirección</th>
                                            <th>Cliente</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sucursales as $sucursal)
                                        <tr>
                                            <td>{{ $sucursal->id }}</td>
                                            <td>{{ $sucursal->nombre_sucursal }}</td>
                                            <td>{{ $sucursal->telefono_sucursal }}</td>
                                            <td>{{ $sucursal->direccion_sucursal }}</td>
                                            <td>{{ $sucursal->cliente->nombre_cliente ?? 'No asignado' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Contactos -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Contactos</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th>Departamento</th>
                                            <th>Cargo</th>
                                            <th>Email</th>
                                            <th>Sucursal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contactos as $contacto)
                                        <tr>
                                            <td>{{ $contacto->id }}</td>
                                            <td>{{ $contacto->nombre_contacto }}</td>
                                            <td>{{ $contacto->telefono_contacto }}</td>
                                            <td>{{ $contacto->departamento_contacto }}</td>
                                            <td>{{ $contacto->cargo_contacto }}</td>
                                            <td>{{ $contacto->email_contacto }}</td>
                                            <td>{{ $contacto->sucursal->nombre_sucursal ?? 'No asignada' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Servicios -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Servicios</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Tipo de Servicio</th>
                                            <th>Sublínea</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($servicios as $servicio)
                                        <tr>
                                            <td>{{ $servicio->id }}</td>
                                            <td>{{ $servicio->nombre_servicio }}</td>
                                            <td>{{ $servicio->tipoServicio->descripcion_tipo_servicio ?? 'No asignado' }}
                                            </td>
                                            <td>{{ $servicio->sublinea->nombre_sublinea ?? 'No asignada' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Técnico-Servicios -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Técnico-Servicios</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Técnico</th>
                                            <th>Servicio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tecnico_servicios as $tecnico_servicio)
                                        <tr>
                                            <td>{{ $tecnico_servicio->id }}</td>
                                            <td>{{ $tecnico_servicio->tecnico->nombre_tecnico ?? 'No asignado' }}
                                            </td>
                                            <td>{{ $tecnico_servicio->servicio->nombre_servicio ?? 'No asignado' }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Tareas -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Tareas</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Tiempo</th>
                                            <th>Servicio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tareas as $tarea)
                                        <tr>
                                            <td>{{ $tarea->id }}</td>
                                            <td>{{ $tarea->nombre_tarea }}</td>
                                            <td>{{ $tarea->tiempo_tarea }}</td>
                                            <td>{{ $tarea->servicio->nombre_servicio ?? 'No asignado' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Dispositivos -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Dispositivos</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Número de Serie</th>
                                            <th>Modelo</th>
                                            <th>Sucursal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dispositivos as $dispositivo)
                                        <tr>
                                            <td>{{ $dispositivo->id }}</td>
                                            <td>{{ $dispositivo->numero_serie_dispositivo }}</td>
                                            <td>{{ $dispositivo->modelo->nombre_modelo ?? 'No asignado' }}</td>
                                            <td>{{ $dispositivo->sucursal->nombre_sucursal ?? 'No asignada' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Dispositivos OT -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Dispositivos OT</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Dispositivo</th>
                                            <th>OT</th>
                                            <th>Detalles</th>
                                            <th>Accesorios</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dispositivos_ot as $dispositivo_ot)
                                        <tr>
                                            <td>{{ $dispositivo_ot->id }}</td>
                                            <td>{{ $dispositivo_ot->dispositivo->numero_serie_dispositivo ?? 'No asignado' }}
                                            </td>
                                            <td>{{ $dispositivo_ot->ot->numero_ot ?? 'No asignado' }}</td>
                                            <td>{{ $dispositivo_ot->detalles ? 'Sí' : 'No' }}</td>
                                            <td>{{ $dispositivo_ot->accesorios ? 'Sí' : 'No' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Tareas OT -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Tareas OT</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Tarea</th>
                                            <th>OT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tareas_ot as $tarea_ot)
                                        <tr>
                                            <td>{{ $tarea_ot->id }}</td>
                                            <td>{{ $tarea_ot->tarea->nombre_tarea ?? 'No asignada' }}</td>
                                            <td>{{ $tarea_ot->ot->numero_ot ?? 'No asignada' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Contactos OT -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Contactos OT</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Contacto</th>
                                            <th>OT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contactos_ot as $contacto_ot)
                                        <tr>
                                            <td>{{ $contacto_ot->id }}</td>
                                            <td>{{ $contacto_ot->contacto->nombre_contacto ?? 'No asignado' }}</td>
                                            <td>{{ $contacto_ot->ot->numero_ot ?? 'No asignado' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <!-- Equipos Técnicos -->
                        <details style="width: 100%;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Equipos Técnicos</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Técnico</th>
                                            <th>OT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipos_tecnicos as $equipo_tecnico)
                                        <tr>
                                            <td>{{ $equipo_tecnico->id }}</td>
                                            <td>{{ $equipo_tecnico->tecnico->nombre_tecnico ?? 'No asignado' }}
                                            </td>
                                            <td>{{ $equipo_tecnico->ot->numero_ot ?? 'No asignado' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </details>


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
