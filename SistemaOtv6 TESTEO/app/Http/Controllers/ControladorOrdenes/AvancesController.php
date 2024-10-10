<?php

namespace App\Http\Controllers\ControladorOrdenes;

use App\Http\Controllers\Controller;
use App\Models\Avance;
use App\Models\Ot;
use App\Models\EstadoOt;
use Illuminate\Http\Request;

class AvancesController extends Controller
{
    public function index($numero_ot)
    {
        $orden = Ot::with('avances')->where('numero_ot', $numero_ot)->firstOrFail();
        return view('ordenes.avances', compact('orden'));
    }

    public function store(Request $request, $numero_ot)
    {
        // Obtener la OT
        $orden = Ot::where('numero_ot', $numero_ot)->firstOrFail();

        // Verificar si la OT está finalizada
        if ($orden->estado->descripcion_estado_ot === 'Finalizada') {
            return redirect()->route('ordenes.avances', $numero_ot)->with('error', 'No se pueden agregar más avances a una OT finalizada.');
        }

        $request->validate([
            'comentario_avance' => 'required|string',
            'fecha_avance' => 'required|date',
            'tiempo_avance' => 'required|integer',
        ]);

        Avance::create([
            'comentario_avance' => $request->comentario_avance,
            'fecha_avance' => $request->fecha_avance,
            'tiempo_avance' => $request->tiempo_avance,
            'cod_ot' => $numero_ot,
        ]);

        return redirect()->route('ordenes.avances', $numero_ot)->with('success', 'Avance agregado exitosamente.');
    }

    public function finalizar(Request $request, $numero_ot)
    {
        // Obtener la OT
        $orden = Ot::where('numero_ot', $numero_ot)->firstOrFail();

        // Verificar si la OT ya está finalizada
        if ($orden->estado->descripcion_estado_ot === 'Finalizada') {
            return redirect()->route('ordenes.avances', $numero_ot)->with('error', 'La OT ya está finalizada y no se puede volver a finalizar.');
        }

        // Validar el avance final
        $request->validate([
            'comentario_avance' => 'required|string',
            'fecha_avance' => 'required|date',
            'tiempo_avance' => 'required|integer',
        ]);

        // Obtener el estado 'Finalizada' de la tabla `estado_ot`
        $estadoFinalizada = EstadoOt::where('descripcion_estado_ot', 'Finalizada')->firstOrFail();

        // Cambiar el estado de la OT a "Finalizada"
        $orden->cod_estado_ot = $estadoFinalizada->id;
        $orden->save();

        // Crear el último avance
        Avance::create([
            'comentario_avance' => $request->comentario_avance,
            'fecha_avance' => $request->fecha_avance,
            'tiempo_avance' => $request->tiempo_avance,
            'cod_ot' => $numero_ot,
        ]);

        return redirect()->route('ordenes.avances', $numero_ot)->with('success', 'OT finalizada y avance agregado exitosamente.');
    }
}
