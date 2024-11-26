<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    public function index(Request $request)
    {

        $subcategorias = Subcategoria::with('categoria')->paginate(10, ['*'], 'subcategorias_page');


        if ($request->ajax()) {

            return view('subcategoria.index', compact('subcategorias'))->render();
        }


        return view('subcategoria.index', compact('subcategorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('subcategoria.crear', compact('categorias'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_subcategoria' => 'required|string|max:255',
            'cod_categoria' => 'required|exists:categoria,id',
        ]);

        $subcategoria = Subcategoria::create([
            'nombre_subcategoria' => $request->input('nombre_subcategoria'),
            'cod_categoria' => $request->input('cod_categoria'),
        ]);

        $categoria = Categoria::find($request->input('cod_categoria'));

        return redirect()->route('parametros.index')->with([
            'success' => 'Subcategoría creada exitosamente',
            'subcategoria_nombre' => $subcategoria->nombre_subcategoria,
            'categoria_nombre' => $categoria->nombre_categoria,
        ]);
    }

    public function show($id)
    {
        $subcategoria = Subcategoria::with('categoria')->findOrFail($id);

        return view('subcategoria.detalle', compact('subcategoria'));
    }

    public function edit($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $categorias = Categoria::all();
        return view('subcategoria.editar', compact('subcategoria', 'categorias'));
    }

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

    public function destroy($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->delete();

        return redirect()->route('parametros.index')->with('success', 'Subcategoría eliminada exitosamente');
    }
}
