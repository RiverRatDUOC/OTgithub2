<?php

namespace App\Http\Controllers\ControladorSucursales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sucursal;

class SucursalesController extends Controller
{
    public function index()
    {
        // Ordenar las sucursales de manera descendente por el campo 'id' o cualquier otro campo relevante
        $sucursales = Sucursal::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('sucursales.sucursales', compact('sucursales'));
    }

    public function create()
    {
        return view('sucursales.agregar');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar sucursales por cualquier campo relevante y ordenar los resultados de manera descendente
        $sucursales = Sucursal::where('nombre_sucursal', 'like', "%$search%")
            ->orWhere('telefono_sucursal', 'like', "%$search%")
            ->orWhere('direccion_sucursal', 'like', "%$search%")
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id' o cualquier otro campo relevante
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('sucursales.sucursales', compact('sucursales'));
    }
}
