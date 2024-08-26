<?php

namespace App\Http\Controllers\ControladorOrdenes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\EstadoOt;
use Illuminate\Http\Request;
use App\Models\Ot;
use App\Models\PrioridadOt;
use App\Models\Servicio;
use App\Models\Sucursal;
use App\Models\Tecnico;
use App\Models\TipoOt;
use App\Models\TipoVisita;

class OrdenesController extends Controller
{
    public function index()
    {
        $ordenes = Ot::with([
            'contacto',
            'servicio',
            'tecnicoEncargado',
            'estado',
            'prioridad',
            'tipo',
            'tipoVisita',
            'contactoOt' // Integración de la relación contactoOt
        ])
            ->orderBy('created_at', 'desc')
            ->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        return view('ordenes.ordenes', compact('ordenes'));
    }

    public function create()
    {
        $tipos = TipoOt::all();
        $prioridades = PrioridadOt::all();
        $estados = EstadoOt::all();
        $tiposVisitas = TipoVisita::all();
        $tecnicos = Tecnico::all();
        $clientes = Cliente::all();
        $servicios = Servicio::all();

        return view('ordenes.agregar', compact('tipos', 'prioridades', 'estados', 'tiposVisitas', 'tecnicos', 'clientes', 'servicios'));
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        $ordenes = Ot::with([
            'contacto',
            'contacto.sucursal',
            'contacto.sucursal.cliente',
            'servicio',
            'tecnicoEncargado',
            'estado',
            'prioridad',
            'tipo',
            'tipoVisita',
            'contactoOt'
        ])
            ->where('numero_ot', 'like', "%$search%")
            ->orWhere('descripcion_ot', 'like', "%$search%")
            ->orWhere('cotizacion', 'like', "%$search%")
            ->orWhereHas('contacto', function ($query) use ($search) {
                $query->where('nombre_contacto', 'like', "%$search%")
                    ->orWhereHas('sucursal', function ($query) use ($search) {
                        $query->where('direccion_sucursal', 'like', "%$search%")
                            ->orWhereHas('cliente', function ($query) use ($search) {
                                $query->where('nombre_cliente', 'like', "%$search%");
                            });
                    });
            })
            ->orWhereHas('servicio', function ($query) use ($search) {
                $query->where('nombre_servicio', 'like', "%$search%");
            })
            ->orWhereHas('tecnicoEncargado', function ($query) use ($search) {
                $query->where('nombre_tecnico', 'like', "%$search%");
            })
            ->orWhereHas('estado', function ($query) use ($search) {
                $query->where('descripcion_estado_ot', 'like', "%$search%");
            })
            ->orWhereHas('prioridad', function ($query) use ($search) {
                $query->where('descripcion_prioridad_ot', 'like', "%$search%");
            })
            ->orWhereHas('tipo', function ($query) use ($search) {
                $query->where('descripcion_tipo_ot', 'like', "%$search%");
            })
            ->orWhereHas('tipoVisita', function ($query) use ($search) {
                $query->where('descripcion_tipo_visita', 'like', "%$search%");
            })
            ->orWhereHas('contactoOt', function ($query) use ($search) {
                $query->whereHas('contacto', function ($query) use ($search) {
                    $query->where('nombre_contacto', 'like', "%$search%")
                        ->orWhereHas('sucursal', function ($query) use ($search) {
                            $query->where('direccion_sucursal', 'like', "%$search%")
                                ->orWhereHas('cliente', function ($query) use ($search) {
                                    $query->where('nombre_cliente', 'like', "%$search%");
                                });
                        });
                });
            })
            ->orderBy('numero_ot', 'desc')  // Ordena por `numero_ot` en orden ascendente
            ->paginate(50);

        return view('ordenes.ordenes', compact('ordenes'));
    }




    public function show($id)
    {
        $orden = Ot::with([
            'contacto',
            'servicio',
            'tecnicoEncargado',
            'estado',
            'prioridad',
            'tipo',
            'tipoVisita',
            'contactoOt' // Integración de la relación contactoOt
        ])
            ->findOrFail($id);

        return view('ordenes.detalle', compact('orden'));
    }

    public function tareas($id)
    {
        $servicio = Servicio::findOrFail($id);
        $tareas = $servicio->tareas;

        return response()->json($tareas);
    }

    public function sucursales($id)
    {
        $cliente = Cliente::findOrFail($id);
        $sucursales = $cliente->sucursal;

        return response()->json($sucursales);
    }

    public function contactos($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $contactos = $sucursal->contacto;

        return response()->json($contactos);
    }
}
