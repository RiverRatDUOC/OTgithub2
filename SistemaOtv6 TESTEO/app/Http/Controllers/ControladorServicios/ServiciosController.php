<?php

namespace App\Http\Controllers\ControladorServicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class ServiciosController extends Controller
{
    public function index()
    {
        // Ordenar los servicios de manera descendente por el campo 'id' o cualquier otro campo relevante
        $servicios = Servicio::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('servicios.servicios', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.agregar');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar servicios por cualquier campo relevante y ordenar los resultados de manera descendente
        $servicios = Servicio::where('nombre_servicio', 'like', "%$search%")
            ->orWhere('cod_tipo_servicio', 'like', "%$search%")
            ->orWhere('cod_sublinea', 'like', "%$search%")
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id' o cualquier otro campo relevante
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('servicios.servicios', compact('servicios'));
    }
}
