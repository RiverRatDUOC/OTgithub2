<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Linea;
use App\Models\Subcategoria; // Asegúrate de que la relación exista
use Illuminate\Http\Request;

class LineaController extends Controller
{
    // Muestra la lista de líneas
    public function index()
    {
        $lineas = Linea::all();
        return view('lineas.index', compact('lineas'));
    }

    // Muestra el formulario de creación de una nueva línea
    public function create()
    {
        $subcategorias = Subcategoria::all(); // Obtén todas las subcategorías para el formulario
        return view('lineas.agregar', compact('subcategorias'));
    }

    // Almacena una nueva línea
    public function store(Request $request)
    {
        $request->validate([
            'nombre_linea' => 'required|string|max:255',
            'cod_subcategoria' => 'required|exists:subcategoria,id', // Asegúrate de que la subcategoría exista
        ]);

        Linea::create([
            'nombre_linea' => $request->input('nombre_linea'),
            'cod_subcategoria' => $request->input('cod_subcategoria'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Línea creada exitosamente');
    }

    // Muestra el detalle de una línea específica
    public function show($id)
    {
        $linea = Linea::findOrFail($id);
        return view('lineas.detalle', compact('linea'));
    }

    // Muestra el formulario para editar una línea
    public function edit($id)
    {
        $linea = Linea::findOrFail($id);
        $subcategorias = Subcategoria::all(); // Obtén todas las subcategorías para el formulario
        return view('lineas.editar', compact('linea', 'subcategorias'));
    }

    // Actualiza una línea existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_linea' => 'required|string|max:255',
            'cod_subcategoria' => 'required|exists:subcategoria,id', // Asegúrate de que la subcategoría exista
        ]);

        $linea = Linea::findOrFail($id);
        $linea->update([
            'nombre_linea' => $request->input('nombre_linea'),
            'cod_subcategoria' => $request->input('cod_subcategoria'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Línea actualizada exitosamente');
    }

    // Elimina una línea
    public function destroy($id)
    {
        $linea = Linea::findOrFail($id);
        $linea->delete();

        return redirect()->route('parametros.index')->with('success', 'Línea eliminada exitosamente');
    }
}
