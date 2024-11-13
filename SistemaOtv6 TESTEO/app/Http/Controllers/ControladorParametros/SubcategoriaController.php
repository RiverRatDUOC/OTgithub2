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
            'cod_categoria' => 'required|exists:categoria,id',
        ]);

        Subcategoria::create([
            'nombre_subcategoria' => $request->input('nombre_subcategoria'),
            'cod_categoria' => $request->input('cod_categoria'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Subcategoría creada exitosamente');
    }

    // Muestra el detalle de una subcategoría específica
    public function show($id)
    {
        $subcategoria = Subcategoria::with('categoria')->findOrFail($id);
        return view('subcategoria.detalle', compact('subcategoria'));
    }

    // Muestra el formulario para editar una subcategoría
    public function edit($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $categorias = Categoria::all();
        return view('subcategoria.editar', compact('subcategoria', 'categorias'));
    }

    // Actualiza una subcategoría existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_subcategoria' => 'required|string|max:255',
            'cod_categoria' => 'required|exists:categoria,id',
        ]);

        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->update([
            'nombre_subcategoria' => $request->input('nombre_subcategoria'),
            'cod_categoria' => $request->input('cod_categoria'),
        ]);

        return redirect()->route('parametros.index')->with('success', 'Subcategoría actualizada exitosamente');
    }

    // Elimina una subcategoría
    public function destroy($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->delete();

        return redirect()->route('parametros.index')->with('success', 'Subcategoría eliminada exitosamente');
    }
}
