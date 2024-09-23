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
                    <h2>Dispositivos</h2>
                </div>

                <!-- Formulario de Búsqueda -->
                <div>
                    <form action="{{ route('dispositivos.buscar') }}" method="get" class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por número de serie o modelo" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
                    </form>
                </div>

                <!-- Botones de Agregar y Eliminar Filtro -->
                <div class="d-flex align-items-center justify-content-end mt-3" style="gap: 1rem;">
                    <a href="{{ route('dispositivos.create') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-plus"></i> Agregar
                    </a>
                    <a href="{{ route('dispositivos.index') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-x-circle"></i> Eliminar Filtro
                    </a>
                </div>

                <!-- Tabla de Dispositivos -->
                <div class="table-responsive mt-3">
                    <table class="table table-striped" id="dispositivos_tabledata">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Id</th>
                                <th onclick="sortTable(1)">Número de Serie</th>
                                <th onclick="sortTable(2)">Modelo</th>
                                <th onclick="sortTable(3)">Sucursal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dispositivos as $dispositivo)
                            <tr>
                                <td>{{ $dispositivo->id }}</td>
                                <td>{{ $dispositivo->numero_serie_dispositivo ?? 'No disponible' }}</td>
                                <td>{{ $dispositivo->modelo->nombre_modelo ?? 'No disponible' }}</td>
                                <td>{{ $dispositivo->sucursal->nombre_sucursal ?? 'No disponible' }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('dispositivos.show', $dispositivo->id) }}" class="btn btn-primary me-1" style="background-color: #cc0066; border-color: #cc0066; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dispositivos.edit', $dispositivo->id) }}" class="btn btn-primary me-1" style="background-color: #cc6633; border-color: #cc6633; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dispositivos.destroy', $dispositivo->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="background-color: #d9534f; border-color: #d43f3a; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    @if ($dispositivos->hasPages())
                    <nav>
                        <ul class="pagination" style="color: #cc6633;">
                            {{-- First Page Link --}}
                            @if ($dispositivos->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $dispositivos->url(1) }}" rel="prev" style="color: #cc6633;">&laquo;</a>
                            </li>
                            @endif

                            {{-- Previous Page Link --}}
                            @if ($dispositivos->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $dispositivos->previousPageUrl() }}" rel="prev" style="color: #cc6633;">&lsaquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($dispositivos->getUrlRange(max(1, $dispositivos->currentPage() - 5), min($dispositivos->lastPage(), $dispositivos->currentPage() + 5)) as $page => $url)
                            @if ($page == $dispositivos->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}" style="color: #cc6633;">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($dispositivos->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $dispositivos->nextPageUrl() }}" rel="next" style="color: #cc6633;">&rsaquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                            </li>
                            @endif

                            {{-- Last Page Link --}}
                            @if ($dispositivos->currentPage() == $dispositivos->lastPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&raquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $dispositivos->url($dispositivos->lastPage()) }}" rel="next" style="color: #cc6633;">&raquo;</a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/mensajes/mensajes.js') }}"></script>
<script src="{{ asset('assets/js/ordenar/OrdenarDispositivo.js') }}"></script>

@endsection