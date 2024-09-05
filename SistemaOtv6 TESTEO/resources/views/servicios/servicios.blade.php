@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<link rel="stylesheet" href="{{ URL::to('assets/css/profile.css') }}">

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Encabezado -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Servicios</h2>
                </div>

                <!-- Formulario de Búsqueda -->
                <div>
                    <form action="{{ route('servicios.buscar') }}" method="get" class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por ID, nombre, requerimiento o código sublinea" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
                    </form>
                </div>

                <!-- Botones de Agregar y Eliminar Filtro -->
                <div class="d-flex align-items-center justify-content-end mt-3" style="gap: 1rem;">
                    <a href="{{ route('servicios.create') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-plus"></i> Agregar
                    </a>
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-x-circle"></i> Eliminar Filtro
                    </a>
                </div>

                <!-- Tabla de Servicios -->
                <div class="table-responsive mt-3">
                    <table class="table table-striped" id="servicios_tabledata">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Id</th>
                                <th onclick="sortTable(1)">Nombre Servicio</th>
                                <th onclick="sortTable(2)">Requerimiento</th>
                                <th onclick="sortTable(3)">Código Sublinea</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servicios as $servicio)
                            <tr>
                                <td>{{ $servicio->id }}</td>
                                <td>{{ $servicio->nombre_servicio }}</td>
                                <td>{{ optional($servicio->tipoServicio)->descripcion_tipo_servicio }}</td>
                                <td>{{ optional($servicio->sublinea)->nombre_sublinea }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="" class="btn btn-primary me-1" style="background-color: #cc0066; border-color: #cc0066;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="" class="btn btn-primary me-1" style="background-color: #cc6633; border-color: #cc6633;">
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

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    @if ($servicios->hasPages())
                    <nav>
                        <ul class="pagination" style="color: #cc6633;">
                            {{-- First Page Link --}}
                            @if ($servicios->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $servicios->url(1) }}" rel="prev" style="color: #cc6633;">&laquo;</a>
                            </li>
                            @endif

                            {{-- Previous Page Link --}}
                            @if ($servicios->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $servicios->previousPageUrl() }}" rel="prev" style="color: #cc6633;">&lsaquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($servicios->getUrlRange(max(1, $servicios->currentPage() - 5), min($servicios->lastPage(), $servicios->currentPage() + 5)) as $page => $url)
                            @if ($page == $servicios->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}" style="color: #cc6633;">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($servicios->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $servicios->nextPageUrl() }}" rel="next" style="color: #cc6633;">&rsaquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                            </li>
                            @endif

                            {{-- Last Page Link --}}
                            @if ($servicios->currentPage() == $servicios->lastPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&raquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $servicios->url($servicios->lastPage()) }}" rel="next" style="color: #cc6633;">&raquo;</a>
                            </li>
                            @endif
                        </ul>
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
<script src="{{ asset('assets/js/ordenar/OrdenarServicio.js') }}"></script>

@endsection