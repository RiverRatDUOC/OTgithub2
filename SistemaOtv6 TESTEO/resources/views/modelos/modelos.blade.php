@extends('layouts.master')

@section('content')

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Filtros -->
                <div class="d-flex justify-content-between align-items-center text-center mt-3">
                    <div class="d-flex flex-column align-items-start">
                        <h2>Filtrar Modelos</h2>
                        <form id="filter-form" action="{{ route('modelos.index') }}" method="get" class="input-group mt-3">
                            <div class="row g-2">
                                <div class="col-md-4 mb-2">
                                    <select name="categoria" class="form-control form-control-sm w-100" onchange="this.form.submit()">
                                        <option value="">Seleccionar Categoría</option>
                                        @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre_categoria }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select name="subcategoria" class="form-control form-control-sm w-100" onchange="this.form.submit()">
                                        <option value="">Seleccionar Subcategoría</option>
                                        @foreach ($subcategorias as $subcategoria)
                                        <option value="{{ $subcategoria->id }}" {{ request('subcategoria') == $subcategoria->id ? 'selected' : '' }}>
                                            {{ $subcategoria->nombre_subcategoria }} ({{ $subcategoriaCounts[$subcategoria->id] ?? 0 }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select name="linea" class="form-control form-control-sm w-100" onchange="this.form.submit()">
                                        <option value="">Seleccionar Línea</option>
                                        @foreach ($lineas as $linea)
                                        <option value="{{ $linea->id }}" {{ request('linea') == $linea->id ? 'selected' : '' }}>
                                            {{ $linea->nombre_linea }} ({{ $lineaCounts[$linea->id] ?? 0 }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select name="sublinea" class="form-control form-control-sm w-100" onchange="this.form.submit()">
                                        <option value="">Seleccionar Sublínea</option>
                                        @foreach ($sublineas as $sublinea)
                                        <option value="{{ $sublinea->id }}" {{ request('sublinea') == $sublinea->id ? 'selected' : '' }}>
                                            {{ $sublinea->nombre_sublinea }} ({{ $sublineaCounts[$sublinea->id] ?? 0 }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select name="marca" class="form-control form-control-sm w-100" onchange="this.form.submit()">
                                        <option value="">Seleccionar Marca</option>
                                        @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}" {{ request('marca') == $marca->id ? 'selected' : '' }}>
                                            {{ $marca->nombre_marca }} ({{ $marcaCounts[$marca->id] ?? 0 }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <select name="modelo" class="form-control form-control-sm w-100" onchange="this.form.submit()">
                                        <option value="">Seleccionar Modelo</option>
                                        @foreach ($modelos as $modelo)
                                        <option value="{{ $modelo->id }}" {{ request('modelo') == $modelo->id ? 'selected' : '' }}>
                                            {{ $modelo->nombre_modelo }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Formulario de Búsqueda
                <div>
                    <form action="{{ route('modelos.buscar') }}" method="get" class="input-group mt-3">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por ID, nombre, número de parte o descripción" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
                    </form>
                </div>-->

                <!-- Botones de Agregar y Eliminar Filtro -->
                <div class="d-flex align-items-center justify-content-end mt-3" style="gap: 1rem;">
                    <a href="{{ route('modelos.create') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-plus"></i> Agregar
                    </a>
                    <a href="{{ route('modelos.index') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-x-circle"></i> Eliminar Filtro
                    </a>
                </div>

                <!-- Tabla de Modelos -->
                <div class="table-responsive mt-3">
                    <table class="table table-striped" id="modelos_tabledata">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Categoría</th>
                                <th onclick="sortTable(1)">Subcategoría</th>
                                <th onclick="sortTable(2)">Línea</th>
                                <th onclick="sortTable(3)">Sublinea</th>
                                <th onclick="sortTable(4)">Marca</th>
                                <th onclick="sortTable(5)">Id</th>
                                <th onclick="sortTable(6)">Nombre Modelo</th>
                                <th onclick="sortTable(7)">Part Number</th>
                                <th onclick="sortTable(8)">Descripción Corta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modelos as $modelo)
                            <tr>
                                <td>{{ optional($modelo->sublinea->linea->subcategoria->categoria)->nombre_categoria }}</td>
                                <td>{{ optional($modelo->sublinea->linea->subcategoria)->nombre_subcategoria }}</td>
                                <td>{{ optional($modelo->sublinea->linea)->nombre_linea }}</td>
                                <td>{{ optional($modelo->sublinea)->nombre_sublinea }}</td>
                                <td>{{ optional($modelo->marca)->nombre_marca }}</td>
                                <td>{{ $modelo->id }}</td>
                                <td>{{ $modelo->nombre_modelo }}</td>
                                <td>{{ $modelo->part_number_modelo }}</td>
                                <td>{{ $modelo->desc_corta_modelo }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('modelos.show', $modelo->id) }}" class="btn btn-primary me-1" style="background-color: #cc0066; border-color: #cc0066; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('modelos.edit', $modelo->id) }}" class="btn btn-primary me-1" style="background-color: #cc6633; border-color: #cc6633; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('modelos.destroy', $modelo->id) }}" method="POST" class="d-inline">
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
                    @if ($modelos->hasPages())
                    <nav>
                        <ul class="pagination" style="color: #cc6633;">
                            {{-- First Page Link --}}
                            @if ($modelos->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $modelos->url(1) }}" rel="prev" style="color: #cc6633;">&laquo;</a>
                            </li>
                            @endif

                            {{-- Previous Page Link --}}
                            @if ($modelos->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $modelos->previousPageUrl() }}" rel="prev" style="color: #cc6633;">&lsaquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($modelos->getUrlRange(max(1, $modelos->currentPage() - 5), min($modelos->lastPage(), $modelos->currentPage() + 5)) as $page => $url)
                            @if ($page == $modelos->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}" style="color: #cc6633;">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($modelos->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $modelos->nextPageUrl() }}" rel="next" style="color: #cc6633;">&rsaquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                            </li>
                            @endif

                            {{-- Last Page Link --}}
                            @if ($modelos->currentPage() == $modelos->lastPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&raquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $modelos->url($modelos->lastPage()) }}" rel="next" style="color: #cc6633;">&raquo;</a>
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
<script src="{{ asset('assets/js/ordenar/OrdenarModelo.js') }}"></script>

@endsection
