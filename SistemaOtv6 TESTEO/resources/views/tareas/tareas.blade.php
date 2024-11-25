@extends('layouts.master')

@section('content')

    <main id="main-content" class="col bg-faded py-3 flex-grow-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- Encabezado -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h2>Tareas</h2>
                    </div>

                    <!-- Formulario de Búsqueda -->
                    <div>
                        <form action="{{ route('tareas.buscar') }}" method="get" class="input-group">
                            <input type="text" name="search" id="search" class="form-control"
                                placeholder="Buscar por nombre de tarea o nombre de servicio"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
                        </form>
                    </div>

                    <!-- Botones de Agregar y Eliminar Filtro -->
                    <div class="d-flex align-items-center justify-content-end mt-3" style="gap: 1rem;">
                        <a href="{{ route('tareas.create') }}" class="btn btn-secondary btn-sm"
                            style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-plus"></i> Agregar
                        </a>
                        <a href="{{ route('tareas.index') }}" class="btn btn-secondary btn-sm"
                            style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-x-circle"></i> Eliminar Filtro
                        </a>
                    </div>

                    <!-- Tabla de Tareas -->
                    <div class="table-responsive mt-3">
                        <table class="table table-striped" id="tareas_tabledata">
                            <thead>
                                <tr>
                                    <th onclick="sortTable(0)">Id</th>
                                    <th onclick="sortTable(1)">Nombre Tarea</th>
                                    <th onclick="sortTable(2)">Nombre Servicio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tareas as $tarea)
                                    <tr>
                                        <td>{{ $tarea->id }}</td>
                                        <td>{{ $tarea->nombre_tarea }}</td>
                                        <td>{{ optional($tarea->servicio)->nombre_servicio }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('tareas.show', $tarea->id) }}"
                                                    class="btn btn-primary me-1"
                                                    style="background-color: #cc0066; border-color: #cc0066; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('tareas.edit', $tarea->id) }}"
                                                    class="btn btn-primary me-1"
                                                    style="background-color: #cc6633; border-color: #cc6633; height: 38px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        style="background-color: #d9534f; border-color: #d43f3a; height: 38px; display: flex; align-items: center; justify-content: center;">
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
                        @if ($tareas->hasPages())
                            <nav>
                                <ul class="pagination" style="color: #cc6633;">
                                    {{-- First Page Link --}}
                                    @if ($tareas->onFirstPage())
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link" style="color: #cc6633;">&laquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $tareas->url(1) }}" rel="prev"
                                                style="color: #cc6633;">&laquo;</a>
                                        </li>
                                    @endif

                                    {{-- Previous Page Link --}}
                                    @if ($tareas->onFirstPage())
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $tareas->previousPageUrl() }}" rel="prev"
                                                style="color: #cc6633;">&lsaquo;</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($tareas->getUrlRange(max(1, $tareas->currentPage() - 5), min($tareas->lastPage(), $tareas->currentPage() + 5)) as $page => $url)
                                        @if ($page == $tareas->currentPage())
                                            <li class="page-item active" aria-current="page"><span class="page-link"
                                                    style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $url }}"
                                                    style="color: #cc6633;">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($tareas->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $tareas->nextPageUrl() }}" rel="next"
                                                style="color: #cc6633;">&rsaquo;</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                                        </li>
                                    @endif

                                    {{-- Last Page Link --}}
                                    @if ($tareas->currentPage() == $tareas->lastPage())
                                        <li class="page-item disabled" aria-disabled="true">
                                            <span class="page-link" style="color: #cc6633;">&raquo;</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $tareas->url($tareas->lastPage()) }}"
                                                rel="next" style="color: #cc6633;">&raquo;</a>
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
    <script src="{{ asset('assets/js/ordenar/OrdenarTarea.js') }}"></script>

@endsection
