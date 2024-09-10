<?php

namespace App\Http\Controllers\ControladorContactos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contacto;
use App\Models\Sucursal;

class ContactosController extends Controller
{
    // Mostrar una lista de contactos con paginación
    public function index()
    {
        $contactos = Contacto::orderBy('id', 'desc')->paginate(50);
        return view('contactos.contactos', compact('contactos'));
    }

    // Mostrar el formulario para crear un nuevo contacto
    public function create()
    {
        $sucursales = Sucursal::all(); // Obtener todas las sucursales
        return view('contactos.agregar', compact('sucursales'));
    }

    // Almacenar un nuevo contacto en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre_contacto' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:255',
            'departamento_contacto' => 'nullable|string|max:255',
            'cargo_contacto' => 'nullable|string|max:255',
            'email_contacto' => 'required|email|max:255',
            'cod_sucursal' => 'required|exists:sucursal,id', // Corregido aquí
        ]);

        // Crear el contacto
        Contacto::create([
            'nombre_contacto' => $request->nombre_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'departamento_contacto' => $request->departamento_contacto,
            'cargo_contacto' => $request->cargo_contacto,
            'email_contacto' => $request->email_contacto,
            'cod_sucursal' => $request->cod_sucursal,
        ]);

        return redirect()->route('contactos.index')->with('success', 'Contacto creado exitosamente.');
    }

    // Mostrar el formulario para editar un contacto
    public function edit($id)
    {
        $contacto = Contacto::findOrFail($id);
        $sucursales = Sucursal::all(); // Obtener todas las sucursales
        return view('contactos.editar', compact('contacto', 'sucursales'));
    }

    // Actualizar un contacto en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_contacto' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:255',
            'departamento_contacto' => 'nullable|string|max:255',
            'cargo_contacto' => 'nullable|string|max:255',
            'email_contacto' => 'required|email|max:255',
            'cod_sucursal' => 'required|exists:sucursal,id', // Corregido aquí
        ]);

        // Encontrar y actualizar el contacto
        $contacto = Contacto::findOrFail($id);
        $contacto->update([
            'nombre_contacto' => $request->nombre_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'departamento_contacto' => $request->departamento_contacto,
            'cargo_contacto' => $request->cargo_contacto,
            'email_contacto' => $request->email_contacto,
            'cod_sucursal' => $request->cod_sucursal,
        ]);

        return redirect()->route('contactos.index')->with('success', 'Contacto actualizado exitosamente.');
    }

    // Eliminar un contacto de la base de datos
    public function destroy($id)
    {
        $contacto = Contacto::findOrFail($id);
        $contacto->delete();

        return redirect()->route('contactos.index')->with('success', 'Contacto eliminado exitosamente.');
    }
    // Mostrar el detalle de un contacto
    public function show($id)
    {
        $contacto = Contacto::findOrFail($id);
        return view('contactos.detalle', compact('contacto'));
    }
    public function buscar(Request $request)
    {
        $search = $request->input('search');

        $contactos = Contacto::where('nombre_contacto', 'like', "%$search%")
            ->orWhere('telefono_contacto', 'like', "%$search%")
            ->orWhere('departamento_contacto', 'like', "%$search%")
            ->orWhere('cargo_contacto', 'like', "%$search%")
            ->orWhere('email_contacto', 'like', "%$search%")
            ->orWhereHas('sucursal', function ($query) use ($search) {
                $query->where('nombre_sucursal', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('contactos.contactos', compact('contactos'));
    }
}
