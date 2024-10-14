<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Muestra la lista de categorías
    public function index()
    {
        $categorias = Categoria::all();
        return view('categoria.index', compact('categorias'));
    }

    // Muestra el formulario de creación de una nueva categoría
    public function create()
    {
        return view('categoria.agregar');
    }

    // Almacena una nueva categoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255',
        ]);

        Categoria::create([
            'nombre_categoria' => $request->input('nombre_categoria'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Categoría creada exitosamente');
    }

    // Muestra el detalle de una categoría específica
    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.detalle', compact('categoria'));
    }

    // Muestra el formulario para editar una categoría
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.editar', compact('categoria'));
    }

    // Actualiza una categoría existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update([
            'nombre_categoria' => $request->input('nombre_categoria'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Categoría actualizada exitosamente');
    }

    // Elimina una categoría
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('parametros.index')->with('success', 'Categoría eliminada exitosamente');
    }
}
