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

                <!-- Categorías -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Categorías</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                        </table>
                        <div style="overflow-y: auto; max-height: 300px;">
                            <table class="table table-striped" style="width: 100%;">
                                <tbody>
                                    @foreach ($categorias as $categoria)
                                    <tr>
                                        <td>{{ $categoria->id }}</td>
                                        <td>{{ $categoria->nombre_categoria }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </details>

                <!-- Subcategorías -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Subcategorías</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                </tr>
                            </thead>
                        </table>
                        <div style="overflow-y: auto; max-height: 300px;">
                            <table class="table table-striped" style="width: 100%;">
                                <tbody>
                                    @foreach ($subcategorias as $subcategoria)
                                    <tr>
                                        <td>{{ $subcategoria->id }}</td>
                                        <td>{{ $subcategoria->nombre_subcategoria }}</td>
                                        <td>{{ $subcategoria->categoria->nombre_categoria ?? 'No asignada' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </details>

                <!-- Líneas -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Líneas</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Subcategoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                        <div style="overflow-y: auto; max-height: 300px;">
                            <table class="table table-striped" style="width: 100%;">
                                <tbody>
                                    @foreach ($lineas as $linea)
                                    <tr>
                                        <td>{{ $linea->id }}</td>
                                        <td>{{ $linea->nombre_linea }}</td>
                                        <td>{{ $linea->subcategoria->nombre_subcategoria ?? 'No asignada' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('lineas.show', $linea->id) }}" class="btn btn-primary me-1" style="background-color: #cc0066; border-color: #cc0066;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </details>

                <!-- Sublíneas -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Sublíneas</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Línea</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                        <div style="overflow-y: auto; max-height: 300px;">
                            <table class="table table-striped" style="width: 100%;">
                                <tbody>
                                    @foreach ($sublineas as $sublinea)
                                    <tr>
                                        <td>{{ $sublinea->id }}</td>
                                        <td>{{ $sublinea->nombre_sublinea }}</td>
                                        <td>{{ $sublinea->linea->nombre_linea ?? 'No asignada' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('parametros.show', $sublinea->id) }}" class="btn btn-primary me-1" style="background-color: #cc0066; border-color: #cc0066;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </details>

                <!-- Marcas -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Marcas</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                        </table>
                        <div style="overflow-y: auto; max-height: 300px;">
                            <table class="table table-striped" style="width: 100%;">
                                <tbody>
                                    @foreach ($marcas as $marca)
                                    <tr>
                                        <td>{{ $marca->id }}</td>
                                        <td>{{ $marca->nombre_marca }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </details>

                <!-- Tipo de OT -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Tipos de OT</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                        </table>
                        <div style="overflow-y: auto; max-height: 300px;">
                            <table class="table table-striped" style="width: 100%;">
                                <tbody>
                                    @foreach ($tipos_ot as $tipo_ot)
                                    <tr>
                                        <td>{{ $tipo_ot->id }}</td>
                                        <td>{{ $tipo_ot->descripcion_tipo_ot }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </details>
                <!-- Prioridades de OT -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Prioridades de OT</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prioridades_ot as $prioridad_ot)
                                <tr>
                                    <td>{{ $prioridad_ot->id }}</td>
                                    <td>{{ $prioridad_ot->descripcion_prioridad_ot }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>

                <!-- Estados de OT -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Estados de OT</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($estados_ot as $estado_ot)
                                <tr>
                                    <td>{{ $estado_ot->id }}</td>
                                    <td>{{ $estado_ot->descripcion_estado_ot }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>
                <!-- Tipos de Visita -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Tipos de Visita</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
                        <table class="table table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tipos_visita as $tipo_visita)
                                <tr>
                                    <td>{{ $tipo_visita->id }}</td>
                                    <td>{{ $tipo_visita->descripcion_tipo_visita }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>
                <!-- Tipos de Servicio -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Tipos de Servicio</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Modelos</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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


                <!-- Usuarios -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Usuarios</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                                    <td>{{ $usuario->email_verified_at ? $usuario->email_verified_at->format('Y-m-d H:i:s') : 'No' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>
                <!-- Técnicos -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Técnicos</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                                    <td>${{ number_format($tecnico->precio_hora_tecnico, ) }}</td>
                                    <td>{{ $tecnico->usuario->nombre_usuario ?? 'No asignado' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>
                <!-- Clientes -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Clientes</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Sucursales</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Contactos</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Servicios</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                                    <td>{{ $servicio->tipoServicio->descripcion_tipo_servicio ?? 'No asignado' }}</td>
                                    <td>{{ $servicio->sublinea->nombre_sublinea ?? 'No asignada' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </details>
                <!-- Técnico-Servicios -->
                <details style="width: 100%;">
                    <summary style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">Técnico-Servicios</summary>
                    <div class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
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
                                    <td>{{ $tecnico_servicio->tecnico->nombre_tecnico ?? 'No asignado' }}</td>
                                    <td>{{ $tecnico_servicio->servicio->nombre_servicio ?? 'No asignado' }}</td>
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

@endsection