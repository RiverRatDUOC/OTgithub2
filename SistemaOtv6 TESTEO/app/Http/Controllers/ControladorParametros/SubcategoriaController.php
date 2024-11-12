<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    // Muestra la lista de subcategorías
    public function index()
    {
        $subcategorias = Subcategoria::with('categoria')->get();
        return view('subcategoria.index', compact('subcategorias'));
    }

    // Muestra el formulario de creación de una nueva subcategoría
    public function create()
    {
        $categorias = Categoria::all();
        return view('subcategoria.crear', compact('categorias'));
    }

    // Almacena una nueva subcategoría
    public function store(Request $request)
    {
        $request->validate([
            'nombre_subcategoria' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Subcategoria::create($request->all());

        return redirect()->route('subcategoria.index')->with('success', 'Subcategoría creada exitosamente');
    }

    // Muestra el detalle de una subcategoría específica
    public function show(Subcategoria $subcategoria)
    {
        $subcategoria->load('categoria');
        return view('subcategoria.detalle', compact('subcategoria'));
    }

    // Muestra el formulario para editar una subcategoría
    public function edit(Subcategoria $subcategoria)
    {
        $categorias = Categoria::all();
        return view('subcategoria.editar', compact('subcategoria', 'categorias'));
    }

    // Actualiza una subcategoría existente
    public function update(Request $request, Subcategoria $subcategoria)
    {
        $request->validate([
            'nombre_subcategoria' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $subcategoria->update($request->all());

        return redirect()->route('subcategoria.index')->with('success', 'Subcategoría actualizada exitosamente');
    }

    // Elimina una subcategoría
    public function destroy(Subcategoria $subcategoria)
    {
        $subcategoria->delete();

        return redirect()->route('subcategoria.index')->with('success', 'Subcategoría eliminada exitosamente');
    }
}
