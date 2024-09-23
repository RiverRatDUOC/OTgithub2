<?php

namespace App\Http\Controllers\ControladorDispositivo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dispositivo;
use App\Models\Modelo;
use App\Models\Sucursal;

class DispositivoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $dispositivos = Dispositivo::with(['modelo', 'sucursal'])
            ->whereHas('modelo', function ($query) use ($search) {
                $query->where('nombre_modelo', 'like', "%$search%");
            })
            ->orWhereHas('sucursal', function ($query) use ($search) {
                $query->where('nombre_sucursal', 'like', "%$search%");
            })
            ->orWhere('numero_serie_dispositivo', 'like', "%$search%")
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('dispositivo.dispositivo', compact('dispositivos'));
    }

    public function create()
    {
        $modelos = Modelo::all(); // Obtener todos los modelos
        $sucursales = Sucursal::all(); // Obtener todas las sucursales
        return view('dispositivo.agregar', compact('modelos', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_serie_dispositivo' => 'required|string|max:255',
            'cod_modelo' => 'required|exists:modelo,id',
            'cod_sucursal' => 'required|exists:sucursal,id',
        ]);

        Dispositivo::create([
            'numero_serie_dispositivo' => $request->numero_serie_dispositivo,
            'cod_modelo' => $request->cod_modelo,
            'cod_sucursal' => $request->cod_sucursal,
        ]);

        return redirect()->route('dispositivos.index')->with('success', 'Dispositivo creado exitosamente.');
    }

    public function show($id)
    {
        $dispositivo = Dispositivo::with(['modelo', 'sucursal'])->findOrFail($id);
        return view('dispositivo.detalle', compact('dispositivo'));
    }


    public function edit($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $modelos = Modelo::all();
        $sucursales = Sucursal::all();
        return view('dispositivo.editar', compact('dispositivo', 'modelos', 'sucursales'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_serie_dispositivo' => 'required|string|max:255',
            'cod_modelo' => 'required|exists:modelo,id',
            'cod_sucursal' => 'required|exists:sucursal,id',
        ]);

        $dispositivo = Dispositivo::findOrFail($id);
        $dispositivo->update([
            'numero_serie_dispositivo' => $request->numero_serie_dispositivo,
            'cod_modelo' => $request->cod_modelo,
            'cod_sucursal' => $request->cod_sucursal,
        ]);

        return redirect()->route('dispositivos.index')->with('success', 'Dispositivo actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $dispositivo->delete();

        return back()->with('success', 'Dispositivo eliminado exitosamente.');
    }

    public function buscar(Request $request)
    {
        return $this->index($request); // Redirigir a la función index para manejar la búsqueda
    }
}
