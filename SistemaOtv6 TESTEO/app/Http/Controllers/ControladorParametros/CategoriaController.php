<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    public function index(Request $request)
    {
        $categorias = Categoria::paginate(10, ['*'], 'categorias_page');

        if ($request->ajax()) {
            return view('parametros._partials.categorias', compact('categorias'))->render();
        }

        return view('parametros.index', compact('categorias'));
    }


    public function trashed()
    {
        $categorias = Categoria::onlyTrashed()->get();
        return view('categoria.trashed', compact('categorias'));
    }

    public function create()
    {
        return view('categoria.agregar');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255',
        ]);

        $categoria = Categoria::create($request->all());

        return redirect()->route('parametros.index')
            ->with('categoria_nombre', $categoria->nombre_categoria)
            ->with('success', 'Categoría creada exitosamente');
    }

    public function show($id)
    {
        $categoria = Categoria::with('subcategorias')->findOrFail($id);
        return view('categoria.detalle', compact('categoria'));
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categoria.editar', compact('categoria'));
    }

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

    // Elimina una categoría (soft delete)
    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $nombre = $categoria->nombre_categoria;
            $categoria->delete();
            return redirect()->route('parametros.index')->with('categoria_deleted', $nombre);
        } catch (\Exception $e) {

            return redirect()->route('parametros.index')->with('delete_error', 'No se pudo eliminar la categoría. Inténtalo de nuevo.');
        }
    }

    public function restore($id)
    {
        $categoria = Categoria::withTrashed()->findOrFail($id);
        $categoria->restore();

        return redirect()->route('parametros.index')->with('success', 'Categoría restaurada exitosamente');
    }

    public function forceDelete($id)
    {
        $categoria = Categoria::withTrashed()->findOrFail($id);
        $categoria->forceDelete();

        return redirect()->route('parametros.index')->with('success', 'Categoría eliminada permanentemente');
    }
}
