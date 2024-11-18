<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Sublinea;
use App\Models\Linea;
use Illuminate\Http\Request;

class SublineaController extends Controller
{
    public function index()
    {
        $sublineas = Sublinea::with('linea')->get();
        return view('sublineas.index', compact('sublineas'));
    }

    public function create()
    {
        $lineas = Linea::all();
        return view('sublineas.crear', compact('lineas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre_sublinea' => 'required|string|max:255',
            'cod_linea' => 'required|exists:linea,id',
        ]);

        Sublinea::create($request->all());

        return redirect()->route('parametros.index')->with('success', 'Sublínea creada exitosamente');
    }

    public function show($id)
    {
        $sublinea = Sublinea::with('linea')->findOrFail($id);
        return view('sublineas.detalle', compact('sublinea'));
    }

    public function edit($id)
    {
        $sublinea = Sublinea::findOrFail($id);
        $lineas = Linea::all();
        return view('sublineas.editar', compact('sublinea', 'lineas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_sublinea' => 'required|string|max:255',
            'cod_linea' => 'required|exists:linea,id',
        ]);

        $sublinea = Sublinea::findOrFail($id);
        $sublinea->update($request->all());

        return redirect()->route('sublineas.index')->with('success', 'Sublínea actualizada exitosamente');
    }

    public function destroy($id)
    {
        $sublinea = Sublinea::findOrFail($id);
        $sublinea->delete();

        return redirect()->route('parametros.index')->with('success', 'Sublínea eliminada exitosamente');
    }
}
