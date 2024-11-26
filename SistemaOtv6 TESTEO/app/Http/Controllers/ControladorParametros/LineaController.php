<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Linea;
use App\Models\Subcategoria;
use Illuminate\Http\Request;

class LineaController extends Controller
{

    public function index()
    {
        $lineas = Linea::with('subcategoria')->paginate(10, ['*'], 'lineas_page');
        if ($request->ajax()) {
            return view('lineas.index', compact('lineas'))->render();
        }
        return view('lineas.index', compact('lineas'));
    }

    public function create()
    {
        $subcategorias = Subcategoria::all();
        return view('lineas.crear', compact('subcategorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_linea' => 'required|string|max:255',
            'cod_subcategoria' => 'required|exists:subcategoria,id',
        ]);

        $linea = Linea::create($request->all());

        $subcategoria = $linea->subcategoria->nombre_subcategoria ?? '';

        session()->flash('linea_nombre', $linea->nombre_linea);
        session()->flash('subcategoria_nombre', $subcategoria);

        return redirect()->route('parametros.index')->with('success', 'Línea creada exitosamente');
    }


    public function show($id)
    {
        $linea = Linea::with(['subcategoria', 'sublines'])->findOrFail($id);
        return view('lineas.detalle', compact('linea'));
    }

    public function edit($id)
    {
        $linea = Linea::findOrFail($id);
        $subcategorias = Subcategoria::all();
        return view('lineas.editar', compact('linea', 'subcategorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_linea' => 'required|string|max:255',
            'cod_subcategoria' => 'required|exists:subcategoria,id',
        ]);

        $linea = Linea::findOrFail($id);
        $linea->update($request->all());

        return redirect()->route('parametros.index')->with('success', 'Línea actualizada exitosamente');
    }

    // Elimina una línea (soft delete)
    public function destroy($id)
    {
        $linea = Linea::findOrFail($id);
        $linea->delete();

        return redirect()->route('parametros.index')->with('success', 'Línea eliminada exitosamente');
    }
}
