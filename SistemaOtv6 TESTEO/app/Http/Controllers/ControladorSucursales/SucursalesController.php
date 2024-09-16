<?php

namespace App\Http\Controllers\ControladorSucursales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Models\Cliente;

class SucursalesController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::orderBy('id', 'desc')->paginate(50);
        return view('sucursales.sucursales', compact('sucursales'));
    }

    public function create()
    {
        $clientes = Cliente::all(); // Obtener todos los clientes
        return view('sucursales.agregar', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_sucursal' => 'required|string|max:255',
            'telefono_sucursal' => 'required|string|max:255',
            'direccion_sucursal' => 'required|string|max:255',
            'cliente_id' => 'required|exists:cliente,id', // Cambiado a 'cliente' en lugar de 'clientes'
        ]);

        // Crear la sucursal con el cliente_id
        Sucursal::create([
            'nombre_sucursal' => $request->nombre_sucursal,
            'telefono_sucursal' => $request->telefono_sucursal,
            'direccion_sucursal' => $request->direccion_sucursal,
            'cod_cliente' => $request->cliente_id, // Asegúrate de que el nombre del campo en la tabla Sucursal sea 'cod_cliente'
        ]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada exitosamente.');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        $sucursales = Sucursal::where('nombre_sucursal', 'like', "%$search%")
            ->orWhere('telefono_sucursal', 'like', "%$search%")
            ->orWhere('direccion_sucursal', 'like', "%$search%")
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('sucursales.sucursales', compact('sucursales'));
    }

    public function show($id)
    {
        $sucursal = Sucursal::with(['cliente'])->findOrFail($id);
        return view('sucursales.detalle', compact('sucursal'));
    }

    public function edit($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $clientes = Cliente::all();
        return view('sucursales.editar', compact('sucursal', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_sucursal' => 'required|string|max:255',
            'telefono_sucursal' => 'required|string|max:255',
            'direccion_sucursal' => 'required|string|max:255',
            'cliente_id' => 'required|exists:cliente,id', // Cambiado a 'cliente' en lugar de 'clientes'
        ]);

        // Encontrar la sucursal y actualizarla
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->update([
            'nombre_sucursal' => $request->nombre_sucursal,
            'telefono_sucursal' => $request->telefono_sucursal,
            'direccion_sucursal' => $request->direccion_sucursal,
            'cod_cliente' => $request->cliente_id, // Asegúrate de que el nombre del campo en la tabla Sucursal sea 'cod_cliente'
        ]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada exitosamente.');
    }

    public function destroy($id)
    {
        // Obtener la sucursal por el ID
        $sucursal = Sucursal::findOrFail($id);

        // Eliminar la sucursal
        $sucursal->delete();

        // Mostrar el mensaje en la misma página y redirigir con JavaScript desde la vista
        return back()->with('success', 'Sucursal eliminada exitosamente. Serás redirigido en unos segundos.');
    }
}
