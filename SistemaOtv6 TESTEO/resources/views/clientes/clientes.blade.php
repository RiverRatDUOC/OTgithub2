@extends('layouts.master')

@section('content')


<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <!-- Encabezado -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h2>Clientes</h2>
                </div>

                <!-- Formulario de Búsqueda -->
                <div>
                    <form action="{{ route('clientes.buscar') }}" method="get" class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por ID, nombre, RUT, correo, teléfono o web" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
                    </form>
                </div>

                <!-- Botones de Agregar y Eliminar Filtro -->
                <div class="d-flex align-items-center justify-content-end mt-3" style="gap: 1rem;">
                    <a href="{{ route('clientes.create') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-plus"></i> Agregar
                    </a>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary btn-sm" style="background-color: #cc6633; border-color: #cc6633;">
                        <i class="bi bi-x-circle"></i> Eliminar Filtro
                    </a>
                </div>

                <!-- Tabla de Clientes -->
                <div class="table-responsive mt-3">
                    <table class="table table-striped" id="clientes_tabledata">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Id</th>
                                <th onclick="sortTable(1)">Nombre</th>
                                <th onclick="sortTable(2)">Rut</th>
                                <th onclick="sortTable(3)">Correo</th>
                                <th onclick="sortTable(4)">Teléfono</th>
                                <th onclick="sortTable(5)">Web</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nombre_cliente }}</td>
                                <td>{{ $cliente->rut_cliente }}</td>
                                <td>{{ $cliente->email_cliente }}</td>
                                <td>{{ $cliente->telefono_cliente }}</td>
                                <td>{{ $cliente->web_cliente }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-primary me-1" style="background-color: #cc0066; border-color: #cc0066;  height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-primary me-1" style="background-color: #cc6633; border-color: #cc6633; height: 38px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="background-color: #d9534f; border-color: #d43f3a;  height: 38px; display: flex; align-items: center; justify-content: center;">
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
                    @if ($clientes->hasPages())
                    <nav>
                        <ul class="pagination" style="color: #cc6633;">
                            {{-- First Page Link --}}
                            @if ($clientes->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->url(1) }}" rel="prev" style="color: #cc6633;">&laquo;</a>
                            </li>
                            @endif

                            {{-- Previous Page Link --}}
                            @if ($clientes->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->previousPageUrl() }}" rel="prev" style="color: #cc6633;">&lsaquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($clientes->getUrlRange(max(1, $clientes->currentPage() - 5), min($clientes->lastPage(), $clientes->currentPage() + 5)) as $page => $url)
                            @if ($page == $clientes->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}" style="color: #cc6633;">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($clientes->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->nextPageUrl() }}" rel="next" style="color: #cc6633;">&rsaquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                            </li>
                            @endif

                            {{-- Last Page Link --}}
                            @if ($clientes->currentPage() == $clientes->lastPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&raquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->url($clientes->lastPage()) }}" rel="next" style="color: #cc6633;">&raquo;</a>
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
<script src="{{ asset('assets/js/ordenar/OrdenarCliente.js') }}"></script>

@endsection
