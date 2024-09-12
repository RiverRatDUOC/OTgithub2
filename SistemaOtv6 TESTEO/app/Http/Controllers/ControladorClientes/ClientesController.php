<?php

namespace App\Http\Controllers\ControladorClientes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{
    public function index()
    {
        // Obtener todos los clientes ordenados de manera descendente por el campo 'id' y paginados
        $clientes = Cliente::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('clientes.clientes', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.agregar');
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'rut_cliente' => 'required|string|max:20',
            'email_cliente' => 'required|email|max:255',
            'telefono_cliente' => 'required|string|max:20',
            'web_cliente' => 'nullable|string|max:255',
        ]);

        // Crear un nuevo cliente
        Cliente::create([
            'nombre_cliente' => $request->input('nombre_cliente'),
            'rut_cliente' => $request->input('rut_cliente'),
            'email_cliente' => $request->input('email_cliente'),
            'telefono_cliente' => $request->input('telefono_cliente'),
            'web_cliente' => $request->input('web_cliente'),
        ]);

        // Mostrar el mensaje en la misma página y redirigir con JavaScript desde la vista
        return back()->with('success', 'Cliente agregado exitosamente. Serás redirigido en unos segundos.');
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
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id'
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('clientes.clientes', compact('clientes'));
    }

    public function show($id)
    {
        // Obtener el cliente por el ID
        $cliente = Cliente::findOrFail($id);

        // Pasar los datos del cliente a la vista de detalle
        return view('clientes.detalle', compact('cliente'));
    }

    public function edit($id)
    {
        // Obtener el cliente por el ID
        $cliente = Cliente::findOrFail($id);

        // Pasar los datos del cliente a la vista de edición
        return view('clientes.editar', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'rut_cliente' => 'required|string|max:20',
            'email_cliente' => 'required|email|max:255',
            'telefono_cliente' => 'required|string|max:20',
            'web_cliente' => 'nullable|string|max:255',
        ]);

        // Obtener el cliente por el ID
        $cliente = Cliente::findOrFail($id);

        // Actualizar la información del cliente
        $cliente->update([
            'nombre_cliente' => $request->input('nombre_cliente'),
            'rut_cliente' => $request->input('rut_cliente'),
            'email_cliente' => $request->input('email_cliente'),
            'telefono_cliente' => $request->input('telefono_cliente'),
            'web_cliente' => $request->input('web_cliente'),
        ]);

        // Mostrar el mensaje en la misma página y redirigir con JavaScript desde la vista
        return back()->with('success', 'Cliente actualizado exitosamente. Serás redirigido en unos segundos.');
    }

    public function destroy($id)
    {
        // Obtener el cliente por el ID
        $cliente = Cliente::findOrFail($id);

        // Eliminar el cliente
        $cliente->delete();

        // Mostrar el mensaje en la misma página y redirigir con JavaScript desde la vista
        return back()->with('success', 'Cliente eliminado exitosamente. Serás redirigido en unos segundos.');
    }
}
