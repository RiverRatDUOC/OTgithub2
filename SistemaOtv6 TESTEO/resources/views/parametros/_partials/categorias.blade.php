<details id="categorias-section" class="categorias-section" open>
    <summary class="categorias-summary categorias-summary-custom">
        Categorías
    </summary>
    <div id="categorias-table" class="table-responsive mt-3 categorias-table">
        <table class="table table-striped">
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
                            <!-- Botón Ver -->
                            <a href="{{ route('categoria.show', $categoria->id) }}" class="btn btn-sm btn-custom-info">
                                <i class="fas fa-eye"></i>
                                Ver
                            </a>

                            <!-- Botón Editar -->
                            <a href="{{ route('categoria.edit', $categoria->id) }}" class="btn btn-sm btn-custom-warning">
                                <i class="fas fa-edit"></i>
                                Editar
                            </a>

                            <!-- Botón Eliminar -->
                            <form action="{{ route('categoria.destroy', $categoria->id) }}" method="POST" class="delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-custom-danger">
                                    <i class="fas fa-trash-alt"></i>
                                    Eliminar
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
    <!-- Botón Agregar Categoría -->
    <a href="{{ route('categoria.create') }}" class="btn btn-sm btn-custom-primary">Agregar Categoría</a>
</details>

<!-- Script para manejo de paginación AJAX para Categorías -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Delegación de Eventos para Paginación AJAX de Categorías
        $(document).on('click', '#categorias-section .pagination a', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');

            // Cargar la tabla de forma dinámica
            loadCategoriasTable(url);
        });

        function loadCategoriasTable(url) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    // Reemplazar únicamente el contenedor de la tabla para mantener otras secciones intactas
                    $('#categorias-table').replaceWith($(data).find('#categorias-table'));
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al cargar los datos. Inténtalo de nuevo.',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        }

        // Confirmación de Eliminación con SweetAlert2 para Categorías
        $(document).on('submit', '.delete-form', function (e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
