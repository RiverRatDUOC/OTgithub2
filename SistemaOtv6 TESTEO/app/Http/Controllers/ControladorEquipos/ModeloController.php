<?php

namespace App\Http\Controllers\ControladorEquipos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modelo;

class ModeloController extends Controller
{
    public function index()
    {
        // Ordenar los modelos de manera descendente por el campo 'id' o cualquier otro campo relevante
        $modelos = Modelo::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('modelos.modelos', compact('modelos'));
    }

    public function create()
    {
        return view('modelos.agregar');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar modelos por 'nombre_modelo', 'cod_sublinea', 'part_number_modelo' o 'nombre_marca' relacionado y ordenar los resultados de manera descendente
        $modelos = Modelo::where('nombre_modelo', 'like', "%$search%")
            ->orWhere('part_number_modelo', 'like', "%$search%")
            ->orWhere('cod_sublinea', 'like', "%$search%")
            ->orWhereHas('marca', function ($query) use ($search) {
                $query->where('nombre_marca', 'like', "%$search%");
            })
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id' o cualquier otro campo relevante
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('modelos.modelos', compact('modelos'));
    }
}
