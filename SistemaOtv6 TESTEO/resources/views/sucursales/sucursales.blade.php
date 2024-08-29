@extends('layouts.master')
@include('layouts.navbar.header')

@section('content')
@include('layouts.sidebar.dashboard')

<link rel="stylesheet" href="{{ URL::to('assets/css/profile.css') }}">

<main id="main-content" class="col bg-faded py-3 flex-grow-1">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center text-center mt-3">
                    <h2>Sucursales</h2>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('sucursales.create') }}" class="btn btn-primary ms-auto" style="background-color: #cc6633; border-color: #cc6633;">
                            <i class="bi bi-plus"></i> Agregar
                        </a>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <form action="{{ route('sucursales.buscar') }}" method="get" class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por...">
                        <button type="submit" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Buscar</button>
                    </form>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-striped" id="sucursales_tabledata">
                        <thead>
                            <tr>
                                <th onclick="sortTable(0)">Id</th>
                                <th onclick="sortTable(1)">Nombre</th>
                                <th onclick="sortTable(2)">Teléfono</th>
                                <th onclick="sortTable(3)">Dirección</th>
                                <th onclick="sortTable(4)">Cliente</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sucursales as $sucursal)
                            <tr>
                                <td>{{ $sucursal->id }}</td>
                                <td>{{ $sucursal->nombre_sucursal }}</td>
                                <td>{{ $sucursal->telefono_sucursal }}</td>
                                <td>{{ $sucursal->direccion_sucursal }}</td>
                                <td>{{ $sucursal->cliente->nombre_cliente }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('sucursales.show', $sucursal->id) }}" class="btn btn-primary me-1" style="background-color: #cc0066; border-color: #cc0066;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-primary me-1" style="background-color: #cc6633; border-color: #cc6633;">
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
                    @if ($sucursales->hasPages())
                    <nav>
                        <ul class="pagination" style="color: #cc6633;">
                            {{-- First Page Link --}}
                            @if ($sucursales->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $sucursales->url(1) }}" rel="prev" style="color: #cc6633;">&laquo;</a>
                            </li>
                            @endif

                            {{-- Previous Page Link --}}
                            @if ($sucursales->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&lsaquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $sucursales->previousPageUrl() }}" rel="prev" style="color: #cc6633;">&lsaquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($sucursales->getUrlRange(max(1, $sucursales->currentPage() - 5), min($sucursales->lastPage(), $sucursales->currentPage() + 5)) as $page => $url)
                            @if ($page == $sucursales->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link" style="background-color: #cc6633; border-color: #cc6633;">{{ $page }}</span></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}" style="color: #cc6633;">{{ $page }}</a></li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($sucursales->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $sucursales->nextPageUrl() }}" rel="next" style="color: #cc6633;">&rsaquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&rsaquo;</span>
                            </li>
                            @endif

                            {{-- Last Page Link --}}
                            @if ($sucursales->currentPage() == $sucursales->lastPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link" style="color: #cc6633;">&raquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $sucursales->url($sucursales->lastPage()) }}" rel="next" style="color: #cc6633;">&raquo;</a>
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

<script src="{{ asset('assets/js/ordenar/OrdenarSucursal.js') }}"></script>

@endsection