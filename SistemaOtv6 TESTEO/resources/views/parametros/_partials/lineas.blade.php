<details style="width: 100%; margin-bottom: 10px;">
    <summary
        style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
        Líneas</summary>
    <div class="table-responsive mt-3"
        style="max-height: 300px; overflow-y: auto; width: 100%;">
        <table class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Subcategoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lineas as $linea)
                <tr>
                    <td>{{ $linea->id }}</td>
                    <td>{{ $linea->nombre_linea }}</td>
                    <td>{{ $linea->subcategoria->nombre_subcategoria ?? 'No asignada' }}</td>
                    <td>
                        <a href="{{ route('lineas.show', $linea->id) }}" class="btn btn-info btn-sm" style="background-color: #cc0066; border-color: #cc0066;">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('lineas.edit', $linea->id) }}" class="btn btn-warning btn-sm" style="background-color: #CC6633; border-color: #CC6633;">
                            <i class="fas fa-edit text-white"></i>
                        </a>
                        <form action="{{ route('lineas.destroy', $linea->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de que deseas eliminar esta línea?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('lineas.create') }}" class="btn btn-primary" style="background-color: #cc6633; border-color: #cc6633;">Agregar Línea</a>
</details>
