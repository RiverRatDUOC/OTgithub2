<?php

namespace App\Http\Controllers\ControladorClientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{
    public function index()
    {
        // Ordenar los clientes de manera descendente por el campo 'id' o cualquier otro campo relevante
        $clientes = Cliente::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('clientes.clientes', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.agregar');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar clientes por cualquier campo relevante y ordenar los resultados de manera descendente
        $clientes = Cliente::where('nombre_cliente', 'like', "%$search%")
            ->orWhere('rut_cliente', 'like', "%$search%")
            ->orWhere('email_cliente', 'like', "%$search%")
            ->orWhere('telefono_cliente', 'like', "%$search%")
            ->orWhere('web_cliente', 'like', "%$search%")
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id' o cualquier otro campo relevante
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('clientes.clientes', compact('clientes'));
    }
}
