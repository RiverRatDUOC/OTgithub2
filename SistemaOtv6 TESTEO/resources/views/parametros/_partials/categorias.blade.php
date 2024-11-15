                        <details style="width: 100%; margin-bottom: 10px;">
                            <summary
                                style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
                                Categorías</summary>
                            <div class="table-responsive mt-3"
                                style="max-height: 300px; overflow-y: auto; width: 100%;">
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Acciones</th> <!-- Columna para acciones -->
                                        </tr>
                                    </thead>
                                    <tbody>
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
                            </div>
                            <a href="{{ route('categoria.create') }}" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Agregar Categoría</a>
                        </details>
