<details id="categorias-section" style="width: 100%; margin-bottom: 10px;" open>
    <summary
        style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
        Categorías
    </summary>
    <div id="categorias-table" class="table-responsive mt-3" style="max-height: 300px; overflow-y: auto; width: 100%;">
        <table class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td>{{ $categoria->nombre_categoria }}</td>
                        <td>
                            <a href="{{ route('categoria.show', $categoria->id) }}" class="btn btn-info btn-sm"
                                style="background-color: #cc0066; border-color: #cc0066;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('categoria.edit', $categoria->id) }}" class="btn btn-warning btn-sm"
                                style="background-color: #CC6633; border-color: #CC6633;">
                                <i class="fas fa-edit text-white"></i>
                            </a>
                            <form action="{{ route('categoria.destroy', $categoria->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                {{ $categorias->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
            </div>
            <div>
                <p class="text-muted">
                    {{ $categorias->firstItem() }} a {{ $categorias->lastItem() }} de {{ $categorias->total() }} resultados.
                </p>
            </div>
        </div>
    </div>
    <a href="{{ route('categoria.create') }}" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Agregar Categoría</a>
</details>

<!-- Script para manejo de paginación AJAX -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');

            // Cargar la tabla de forma dinámica
            loadTable(url);
        });

        function loadTable(url) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $('#categorias-section').replaceWith($(data).find('#categorias-section'));
                },
                error: function () {
                    alert('Error al cargar los datos. Inténtalo de nuevo.');
                }
            });
        }
    });
</script>

<style>
    /* Cambiar color de los números de la paginación */
    .pagination .page-link {
        color: #cc6633; /* Cambia el color de los números */
    }

    /* Cambiar color del número activo */
    .pagination .page-item.active .page-link {
        background-color: #cc6633; /* Fondo del número activo */
        border-color: #cc6633; /* Borde del número activo */
        color: #ffffff; /* Color del texto del número activo */
    }

    /* Cambiar color de los números al pasar el mouse */
    .pagination .page-link:hover {
        background-color: #d39a7e; /* Fondo al hacer hover */
        border-color: #d39a7e; /* Borde al hacer hover */
        color: #ffffff; /* Texto al hacer hover */
    }
</style>
