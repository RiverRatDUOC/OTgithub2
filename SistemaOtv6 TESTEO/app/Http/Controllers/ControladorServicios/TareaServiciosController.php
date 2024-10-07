<?php

namespace App\Http\Controllers\ControladorServicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use App\Models\Servicio;

class TareaServiciosController extends Controller
{
    public function index()
    {
        // Ordenar las tareas de manera descendente por el campo 'id'
        $tareas = Tarea::orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('tareas.tareas', compact('tareas'));
    }

    public function create()
    {
        // Obtener servicios para asociar a la nueva tarea
        $servicios = Servicio::all(); // Ajusta la consulta según tus necesidades
        return view('tareas.agregar', compact('servicios'));
    }

    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'nombre_tarea' => 'required|string|max:255',
            'tiempo_tarea' => 'required|integer',
            'cod_servicio' => 'required|exists:servicio,id', // Asegúrate que este campo se refiere al identificador correcto
        ]);

        // Crear una nueva tarea
        Tarea::create($request->all());

        // Redirigir a la lista de tareas con un mensaje de éxito
        return redirect()->route('tareas.index')->with('success', 'Tarea creada exitosamente.');
    }

    public function show($id)
    {
        // Mostrar detalles de una tarea específica
        $tarea = Tarea::findOrFail($id); // Busca la tarea o lanza un 404 si no se encuentra
        return view('tareas.detalle', compact('tarea'));
    }

    public function edit($id)
    {
        // Obtener la tarea a editar y los servicios disponibles
        $tarea = Tarea::findOrFail($id);
        $servicios = Servicio::all(); // Obtener servicios para la selección

        return view('tareas.editar', compact('tarea', 'servicios'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos de entrada
        $request->validate([
            'nombre_tarea' => 'required|string|max:255',
            'tiempo_tarea' => 'required|integer',
            'cod_servicio' => 'required|exists:servicio,id', // Asegúrate que este campo se refiere al identificador correcto
        ]);

        // Obtener la tarea específica
        $tarea = Tarea::findOrFail($id);

        // Actualizar la tarea
        $tarea->update($request->all());

        // Redirigir a la lista de tareas con un mensaje de éxito
        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada exitosamente.');
    }


    public function destroy($id)
    {
        // Eliminar la tarea
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        // Redirigir a la lista de tareas con un mensaje de éxito
        return redirect()->route('tareas.index')->with('success', 'Tarea eliminada exitosamente.');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar tareas por 'nombre_tarea', 'cod_servicio' o 'nombre_servicio' relacionado y ordenar los resultados de manera descendente
        $tareas = Tarea::where('nombre_tarea', 'like', "%$search%")
            ->orWhere('cod_servicio', 'like', "%$search%")
            ->orWhereHas('servicio', function ($query) use ($search) {
                $query->where('nombre_servicio', 'like', "%$search%");
            })
            ->orderBy('id', 'desc') // Ordenar los resultados de manera descendente por el campo 'id' o cualquier otro campo relevante
            ->paginate(20); // Ajusta el número de resultados por página según tus necesidades

        return view('tareas.tareas', compact('tareas'));
    }
}
