@extends('layouts.master')

@section('content')

<main class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center text-center mt-3">
            <h2>Órdenes</h2>
            <div class="d-flex align-items-center">
                <a href="{{ route('ordenes.create') }}" class="btn btn-primary ms-auto"
                    style="background-color: #cc6633; border-color: #cc6633;">
                    <i class="bi bi-plus"></i> Agregar
                </a>
            </div>
        </div>

        <!-- Formulario para seleccionar la opción de visualización -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <form action="{{ route('ordenes.index') }}" method="get" class="input-group" id="ordenesForm">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="show_all" value="false"
                        {{ $vistaSeleccionada == 'asignadas' ? 'checked' : '' }}
                        {{ isset($tecnico) ? '' : 'disabled' }}
                        onchange="this.form.submit()"> {{-- Mostrar solo si tiene técnico --}}
                    <label class="form-check-label">Órdenes asignadas</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="show_all" value="true"
                        {{ $vistaSeleccionada == 'todas' ? 'checked' : '' }}
                        {{ $puedeCambiarVista ? '' : 'disabled' }}
                        onchange="this.form.submit()"> {{-- Habilitar solo si tiene el permiso --}}
                    <label class="form-check-label">Todas las órdenes</label>
                </div>
            </form>

            <form action="{{ route('ordenes.buscar') }}" method="get" class="input-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por..." value="{{ request()->input('search') }}">

                <input type="hidden" name="show_all" value="{{ request()->input('show_all', 'false') }}">

                <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633; margin-right: 5px;">Buscar</button>

                <a href="{{ route('ordenes.index') }}" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">
                    <i class="bi bi-x-circle"></i> Eliminar Filtro
                </a>
            </form>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-striped" id="ot_tabledata">
                <thead>
                    <tr>
                        <th>#Orden</th>
                        <th>Detalle</th>
                        <th>Cliente</th>
                        <th>Sucursal</th>
                        <th>Servicio</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenes as $orden)
                    <tr>
                        <td>{{ $orden->numero_ot }}</td>
                        <td class="align-middle text-center">
                            <a href="#" style="color: #cc6633;" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="far fa-file-alt fa-2x" style="color: #cc6633;"></i>
                            </a>
                        </td>

                        <!-- Cliente -->
                        <td>
                            @if (isset($orden->contactoOt[0]->contacto->sucursal->cliente->nombre_cliente))
                            {{ html_entity_decode($orden->contactoOt[0]->contacto->sucursal->cliente->nombre_cliente) }}
                            @else
                            No disponible
                            @endif
                        </td>

                        <!-- Sucursal -->
                        <td>
                            @if (isset($orden->contactoOt[0]->contacto->sucursal->direccion_sucursal))
                            {{ html_entity_decode($orden->contactoOt[0]->contacto->sucursal->direccion_sucursal) }}
                            @else
                            No disponible
                            @endif
                        </td>

                        <!-- Servicio -->
                        <td>
                            {{ $orden->servicio->nombre_servicio ?? 'No disponible' }}
                        </td>

                        <!-- Técnico Responsable -->
                        <td>
                            {{ $orden->tecnicoEncargado->nombre_tecnico ?? 'No disponible' }}
                        </td>

                        <!-- Estado -->
                        <td>
                            {{ $orden->estado->descripcion_estado_ot ?? 'No disponible' }}
                        </td>

                        <!-- Fecha de Creación -->
                        <td style="width:10%">
                            {{ $orden->created_at ? date('d-m-Y', strtotime($orden->created_at)) : 'No disponible' }}
                        </td>

                        <!-- Acciones -->
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('ordenes.avances', $orden->numero_ot) }}" class="btn btn-success me-1" style="background-color: #28a745; border-color: #28a745;">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <a href="{{ route('ordenes.show', $orden->numero_ot) }}" class="btn btn-primary me-1"
                                    style="background-color: #cc0066; border-color: #cc0066;" data-bs-toggle="modal"
                                    data-bs-target="#myModal" onclick="showOrderDetails({{ $orden }})">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('ordenes.edit', $orden->numero_ot) }}" class="btn btn-primary me-1"
                                    style="background-color: #cc6633; border-color: #cc6633;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger" style="background-color: #d9534f; border-color: #d43f3a;">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            @if ($ordenes->hasPages())
            <nav>
                <ul class="pagination" style="color: #cc6633;">
                    {{-- First Page Link --}}
                    @if ($ordenes->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="color: #cc6633;">&laquo;</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $ordenes->url(1) }}&show_all={{ $vistaSeleccionada == 'todas' ? 'true' : 'false' }}" rel="prev" style="color: #cc6633;">&laquo;</a>
                    </li>
                    @endif

                    {{-- Previous Page Link --}}
                    @if ($ordenes->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $ordenes->previousPageUrl() }}&show_all={{ $vistaSeleccionada == 'todas' ? 'true' : 'false' }}" rel="prev" style="color: #cc6633;">&lsaquo;</a>
                    </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($ordenes->getUrlRange(max(1, $ordenes->currentPage() - 5), min($ordenes->lastPage(), $ordenes->currentPage() + 5)) as $page => $url)
                    @if ($page == $ordenes->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}&show_all={{ $vistaSeleccionada == 'todas' ? 'true' : 'false' }}" style="color: #cc6633;">{{ $page }}</a></li>
                    @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($ordenes->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $ordenes->nextPageUrl() }}&show_all={{ $vistaSeleccionada == 'todas' ? 'true' : 'false' }}" rel="next" style="color: #cc6633;">&rsaquo;</a>
                    </li>
                    @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                    </li>
                    @endif

                    {{-- Last Page Link --}}
                    @if ($ordenes->currentPage() == $ordenes->lastPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link" style="color: #cc6633;">&raquo;</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $ordenes->url($ordenes->lastPage()) }}&show_all={{ $vistaSeleccionada == 'todas' ? 'true' : 'false' }}" rel="next" style="color: #cc6633;">&raquo;</a>
                    </li>
                    @endif
                </ul>
            </nav>
            @endif
        </div>

        <!-- Modal Structure -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Detalle de la OT</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="modal-description"></p>
                        <a href="#" class="btn btn-danger"><i class="far fa-file-pdf fa-lg"></i> Generar
                            PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function showOrderDetails(order) {
        // Aquí podrías mostrar información real del pedido
        document.getElementById('modal-description').innerText = "Aquí irá la información detallada de la orden.";
    }
</script>
<script src="{{ asset('assets/js/ordenar/OrdenarOt.js') }}"></script>

@endsection
