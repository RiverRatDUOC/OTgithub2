<?php

namespace App\Http\Controllers\ControladorSucursales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Models\Cliente;
use App\Models\Contacto;

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
            'cliente_id' => 'required|exists:cliente,id',
            'contacto_option' => 'required|string',
            'contacto_id' => 'nullable|exists:contacto,id',
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono_contacto' => 'nullable|string|max:255',
            'departamento_contacto' => 'nullable|string|max:255',
            'cargo_contacto' => 'nullable|string|max:255',
            'email_contacto' => 'nullable|email|max:255',
        ]);

        // Determinar si se selecciona un contacto existente o se crea uno nuevo
        if ($request->contacto_option === 'existing') {
            $contactoId = $request->contacto_id;
        } else {
            // Crear un nuevo contacto
            $contacto = Contacto::create([
                'nombre_contacto' => $request->nombre_contacto,
                'telefono_contacto' => $request->telefono_contacto,
                'departamento_contacto' => $request->departamento_contacto,
                'cargo_contacto' => $request->cargo_contacto,
                'email_contacto' => $request->email_contacto,
                'cod_sucursal' => null, // Asegúrate de ajustar esto según la lógica
            ]);
            $contactoId = $contacto->id;
        }

        // Crear la sucursal con el cliente_id y contacto_id
        Sucursal::create([
            'nombre_sucursal' => $request->nombre_sucursal,
            'telefono_sucursal' => $request->telefono_sucursal,
            'direccion_sucursal' => $request->direccion_sucursal,
            'cod_cliente' => $request->cliente_id,
            'cod_contacto' => $contactoId, // Asignar el contacto seleccionado o creado
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
        $sucursal = Sucursal::with(['cliente', 'contacto'])->findOrFail($id);
        return view('sucursales.detalle', compact('sucursal'));
    }
}
