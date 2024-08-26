<?php

namespace App\Http\Controllers\ControladorTecnicos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tecnico;

class TecnicosController extends Controller
{
    public function index()
    {
        // Ordenar los técnicos de manera descendente por el campo 'id' o cualquier otro campo relevante
        $tecnicos = Tecnico::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('tecnicos.tecnicos', compact('tecnicos'));
    }

    public function create()
    {
        return view('tecnicos.agregar');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar técnicos por cualquier campo relevante y ordenar los resultados de manera descendente
        $tecnicos = Tecnico::where('nombre_tecnico', 'like', "%$search%")
            ->orWhere('rut_tecnico', 'like', "%$search%")
            ->orWhere('telefono_tecnico', 'like', "%$search%")
            ->orWhere('email_tecnico', 'like', "%$search%")
            ->orWhere('precio_hora_tecnico', 'like', "%$search%")
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id' o cualquier otro campo relevante
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('tecnicos.tecnicos', compact('tecnicos'));
    }
}
