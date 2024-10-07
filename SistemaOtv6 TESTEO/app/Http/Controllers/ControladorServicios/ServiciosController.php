<?php

namespace App\Http\Controllers\ControladorServicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Sublinea;
use App\Models\TipoServicio;

class ServiciosController extends Controller
{
    public function index()
    {
        // Ordenar los servicios de manera descendente por el campo 'id'
        $servicios = Servicio::orderBy('id', 'desc')->paginate(50);
        return view('servicios.servicios', compact('servicios'));
    }

    public function create()
    {
        // Obtener todos los tipos de servicio y sublíneas
        $tiposServicio = TipoServicio::all();
        $sublineas = Sublinea::all();
        return view('servicios.agregar', compact('tiposServicio', 'sublineas'));
    }


    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombre_servicio' => 'required|string|max:255',
            'cod_tipo_servicio' => 'required|integer',
            'cod_sublinea' => 'required|integer',
        ]);

        // Crear el nuevo servicio
        Servicio::create([
            'nombre_servicio' => $request->nombre_servicio,
            'cod_tipo_servicio' => $request->cod_tipo_servicio,
            'cod_sublinea' => $request->cod_sublinea,
        ]);

        // Redirigir a la lista de servicios con un mensaje de éxito
        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar servicios por nombre, tipo o sublínea
        $servicios = Servicio::where('nombre_servicio', 'like', "%$search%")
            ->orWhere('cod_tipo_servicio', 'like', "%$search%")
            ->orWhere('cod_sublinea', 'like', "%$search%")
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('servicios.servicios', compact('servicios'));
    }

    public function edit($id)
    {
        // Buscar el servicio por ID
        $servicio = Servicio::findOrFail($id);
        // Obtener todos los tipos de servicio y sublíneas
        $tiposServicio = TipoServicio::all();
        $sublineas = Sublinea::all();
        return view('servicios.editar', compact('servicio', 'tiposServicio', 'sublineas'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'nombre_servicio' => 'required|string|max:255',
            'cod_tipo_servicio' => 'required|integer',
            'cod_sublinea' => 'required|integer',
        ]);

        // Encontrar el servicio y actualizarlo
        $servicio = Servicio::findOrFail($id);
        $servicio->update([
            'nombre_servicio' => $request->nombre_servicio,
            'cod_tipo_servicio' => $request->cod_tipo_servicio,
            'cod_sublinea' => $request->cod_sublinea,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        // Buscar el servicio por ID y eliminarlo
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        // Redirigir con un mensaje de éxito
        return back()->with('success', 'Servicio eliminado exitosamente.');
    }
    public function show($id)
    {
        // Buscar el servicio por ID
        $servicio = Servicio::findOrFail($id);
        return view('servicios.detalle', compact('servicio'));
    }
}
