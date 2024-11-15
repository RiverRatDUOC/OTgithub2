<details style="width: 100%; margin-bottom: 10px;">
    <summary
        style="font-size: 1.25rem; padding: 10px; border: 1px solid #ddd; background-color: #f7f7f7; cursor: pointer; width: 100%;">
        Sublíneas</summary>
    <div class="table-responsive mt-3"
        style="max-height: 300px; overflow-y: auto; width: 100%;">
        <table class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Línea</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sublineas as $sublinea)
                <tr>
                    <td>{{ $sublinea->id }}</td>
                    <td>{{ $sublinea->nombre_sublinea }}</td>
                    <td>{{ $sublinea->linea->nombre_linea ?? 'No asignada' }}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('parametros.show', $sublinea->id) }}"
                                class="btn btn-primary me-1"
                                style="background-color: #cc0066; border-color: #cc0066;">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</details>
</div>
</div>
