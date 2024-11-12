<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Sublinea;
use App\Models\Linea; // Asegúrate de que la relación exista
use Illuminate\Http\Request;

class SublineaController extends Controller
{
    // Muestra la lista de sublíneas
    public function index()
    {
        $sublineas = Sublinea::all();
        return view('sublineas.index', compact('sublineas'));
    }

    // Muestra el formulario de creación de una nueva sublínea
    public function create()
    {
        $lineas = Linea::all(); // Obtén todas las líneas para el formulario
        return view('sublineas.agregar', compact('lineas'));
    }

    // Almacena una nueva sublínea
    public function store(Request $request)
    {
        $request->validate([
            'nombre_sublinea' => 'required|string|max:255',
            'cod_linea' => 'required|exists:linea,id', // Asegúrate de que la línea exista
        ]);

        Sublinea::create([
            'nombre_sublinea' => $request->input('nombre_sublinea'),
            'cod_linea' => $request->input('cod_linea'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Sublínea creada exitosamente');
    }

    // Muestra el detalle de una sublínea específica
    public function show($id)
    {
        $sublinea = Sublinea::findOrFail($id);
        return view('sublineas.detalle', compact('sublinea'));
    }

    // Muestra el formulario para editar una sublínea
    public function edit($id)
    {
        $sublinea = Sublinea::findOrFail($id);
        $lineas = Linea::all(); // Obtén todas las líneas para el formulario
        return view('sublineas.editar', compact('sublinea', 'lineas'));
    }

    // Actualiza una sublínea existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_sublinea' => 'required|string|max:255',
            'cod_linea' => 'required|exists:linea,id', // Asegúrate de que la línea exista
        ]);

        $sublinea = Sublinea::findOrFail($id);
        $sublinea->update([
            'nombre_sublinea' => $request->input('nombre_sublinea'),
            'cod_linea' => $request->input('cod_linea'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Sublínea actualizada exitosamente');
    }

    // Elimina una sublínea
    public function destroy($id)
    {
        $sublinea = Sublinea::findOrFail($id);
        $sublinea->delete();

        return redirect()->route('parametros.index')->with('success', 'Sublínea eliminada exitosamente');
    }
}
