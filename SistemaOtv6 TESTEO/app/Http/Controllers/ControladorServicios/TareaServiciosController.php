<?php

namespace App\Http\Controllers\ControladorServicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;

class TareaServiciosController extends Controller
{
    public function index()
    {
        // Ordenar las tareas de manera descendente por el campo 'id' o cualquier otro campo relevante
        $tareas = Tarea::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('tareas.tareas', compact('tareas'));
    }

    public function create()
    {
        return view('tareas.agregar');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar tareas por 'nombre_tarea', 'cod_servicio' o 'nombre_servicio' relacionado y ordenar los resultados de manera descendente
        $tareas = Tarea::where('nombre_tarea', 'like', "%$search%")
            ->orWhere('cod_servicio', 'like', "%$search%")
            ->orWhereHas('servicio', function($query) use ($search) {
                $query->where('nombre_servicio', 'like', "%$search%");
            })
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id' o cualquier otro campo relevante
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('tareas.tareas', compact('tareas'));
    }
}
