<?php

namespace App\Http\Controllers\ControladorTecnicos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tecnico;
use App\Models\Usuario;
use App\Models\TecnicoServicio;
use App\Models\Servicio;

class TecnicosController extends Controller
{
    public function index(Request $request)
    {
        // Se puede utilizar el método buscar desde el index si no se proporciona un término de búsqueda.
        return $this->buscar($request);
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        $tecnicos = Tecnico::where('nombre_tecnico', 'like', "%$search%")
            ->orWhere('rut_tecnico', 'like', "%$search%")
            ->orWhere('telefono_tecnico', 'like', "%$search%")
            ->orWhere('email_tecnico', 'like', "%$search%")
            ->orWhere('precio_hora_tecnico', 'like', "%$search%") // Ajusta según tus necesidades
            ->orderBy('id', 'desc')
            ->paginate(50); // Cambia la paginación si es necesario

        return view('tecnicos.tecnicos', compact('tecnicos'));
    }

    public function create()
    {
        // dd('No llega al controlador');
        // Obtener todos los usuarios y servicios para la vista
        $usuarios = Usuario::all(); // Listar todos los usuarios registrados
        $servicios = Servicio::all(); // Listar todos los servicios disponibles
        return view('tecnicos.agregar', compact('usuarios', 'servicios'));
    }

    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'nombre_tecnico' => 'required|string|max:255',
            'rut_tecnico' => 'required|string|max:255|unique:tecnico',
            'telefono_tecnico' => 'nullable|string|max:255',
            'email_tecnico' => 'nullable|string|email|max:255',
            'precio_hora_tecnico' => 'nullable|numeric',
            'cod_usuario' => 'nullable|exists:usuario,id', // FK opcional a usuario
            'servicios' => 'nullable|array' // Validar que se seleccione uno o varios servicios opcionalmente
        ]);

        // Crear el técnico
        $tecnico = Tecnico::create([
            'nombre_tecnico' => $request->nombre_tecnico,
            'rut_tecnico' => $request->rut_tecnico,
            'telefono_tecnico' => $request->telefono_tecnico,
            'email_tecnico' => $request->email_tecnico,
            'precio_hora_tecnico' => $request->precio_hora_tecnico,
            'cod_usuario' => $request->cod_usuario, // Puede ser nulo
        ]);

        // Asignar los servicios opcionales al técnico
        if ($request->servicios) {
            foreach ($request->servicios as $servicio_id) {
                TecnicoServicio::create([
                    'cod_tecnico' => $tecnico->id,
                    'cod_servicio' => $servicio_id,
                ]);
            }
        }

        return redirect()->route('tecnicos.index')->with('success', 'Técnico creado exitosamente.');
    }
}
