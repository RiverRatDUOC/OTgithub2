<?php

namespace App\Http\Controllers\ControladorOrdenes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Dispositivo;
use App\Models\EstadoOt;
use Illuminate\Http\Request;
use App\Models\Ot;
use App\Models\PrioridadOt;
use App\Models\Servicio;
use App\Models\Sucursal;
use App\Models\Tarea;
use App\Models\Tecnico;
use App\Models\TipoOt;
use App\Models\TipoVisita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        // dd($request);

        $contador = $request->input('contadorBloques');

        $validator = Validator::make($request->all(), [
            'descripcion' => ['required', 'max:1000'],
            'cliente' => ['required', 'exists:cliente,id', 'numeric'],
            'sucursal' => ['required', 'exists:sucursal,id', 'numeric'],
            'contactos' => ['required',  function ($attribute, $value, $fail) {
                foreach ($value as $contacto) {
                    if (!Contacto::find($contacto)) {
                        $fail("El contacto con id $contacto no existe.");
                    }
                }
            }],
            'servicio' => ['required', 'exists:servicio,id', 'numeric'],
            'contadorBloques' => ['required', 'numeric'],
            'tipoServicio' => 'required',
            'tecnicoEncargado' => ['required', 'exists:tecnico,id', 'numeric'],
            'tecnicos' => ['required', function ($attribute, $value, $fail) {
                foreach ($value as $tecnico) {
                    if (!Tecnico::find($tecnico)) {
                        $fail("El tecnico con id $tecnico no existe.");
                    }
                }
            }],
            'estado' => ['required', 'exists:estado_ot,id', 'numeric'],
            'prioridad' => ['required', 'exists:prioridad_ot,id', 'numeric'],
            'tipo' => ['required', 'exists:tipo_ot,id', 'numeric'],
            'tipoVisita' => ['required', 'exists:tipo_visita,id', 'numeric'],
            'fecha' => ['required', 'date'],
            'cotizacion' => ['nullable', 'max:50'],
            'tareasSinD' => ['nullable', 'array'],
            'dispositivos' => ['nullable', function ($attribute, $value, $fail) {
                foreach ($value as $dispositivo) {
                    if (!Dispositivo::find($dispositivo)) {
                        $fail("El dispositivo con id $dispositivo no existe.");
                    }
                }
            }],

        ]);

        for ($i = 0; $i < $contador; $i++) {
            $validator->sometimes('tareasDispositivos-' . $i, 'nullable', function ($input) use ($i) {

                return $input->has('tareasDispositivos-' . $i);
            });
        }

        for ($i = 0; $i < $contador; $i++) {
            $validator->sometimes('detallesDispositivo-' . $i, 'nullable', function ($input) use ($i) {

                return $input->has('detallesDispositivo-' . $i);
            });
        }
        for ($i = 0; $i < $contador; $i++) {
            $validator->sometimes('accesoriosDispositivo-' . $i, 'nullable', function ($input) use ($i) {

                return $input->has('accesoriosDispositivo-' . $i);
            });
        }

        $datosValidados = $validator->validated();
        $tiempoEnMinutos = 0;
        $tiempoEnHoras = 0;
        if ($datosValidados['tipoServicio'] == 1) {
            foreach ($datosValidados['tareasSinD'] as $tarea) {
                $tiempoTarea = Tarea::find($tarea)->tiempo_tarea;
                $tiempoEnMinutos += $tiempoTarea;
            }
            // dd($tiempoEnMinutos);
        } elseif ($datosValidados['tipoServicio'] == 2) {
            for ($i = 0; $i < $datosValidados['contadorBloques']; $i++) {
                if (isset($datosValidados['tareasDispositivos-' . $i])) {
                    foreach ($datosValidados['tareasDispositivos-' . $i] as $tarea) {
                        $tiempoTarea = Tarea::find($tarea)->tiempo_tarea;
                        $tiempoEnMinutos += $tiempoTarea;
                    }
                }
            }
            // dd($tiempoEnMinutos);
        }

        $tiempoEnHoras = ceil($tiempoEnMinutos / 60);


        $ot = new Ot();
        $ot->tiempo_ot = $tiempoEnMinutos;
        $ot->horas_ot = $tiempoEnHoras;
        $ot->descripcion_ot = $datosValidados['descripcion'];
        $ot->cotizacion = $datosValidados['cotizacion'];
        $ot->cod_tipo_ot = $datosValidados['tipo'];
        $ot->cod_prioridad_ot = $datosValidados['prioridad'];
        $ot->cod_estado_ot = $datosValidados['estado'];
        $ot->cod_tipo_visita = $datosValidados['tipoVisita'];
        $ot->cod_servicio = $datosValidados['servicio'];
        $ot->cod_contacto = 114; // lmao
        $ot->cod_tecnico_encargado = $datosValidados['tecnicoEncargado'];
        $ot->fecha_inicio_planificada_ot = $datosValidados['fecha'];
        $ot->fecha_fin_planificada_ot = $datosValidados['fecha'];
        $ot->save();

        dd($datosValidados);
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

    public function dispositivos($idSucursal, $idServicio)
    {
        $servicio = Servicio::findOrFail($idServicio);
        if ($servicio->cod_tipo_servicio != 2) {
            return response()->json([]);
        }
        $sublinea = Servicio::findOrFail($idServicio)->sublinea->cod_linea;
        $sucursal = Sucursal::findOrFail($idSucursal);
        $dispositivos = $sucursal
            ->dispositivo()
            ->with('modelo', 'modelo.sublinea')
            ->whereHas('modelo.sublinea', function ($query) use ($sublinea) {
                $query->where('cod_linea', $sublinea);
            })
            ->get();

        return response()->json($dispositivos);
    }

    public function servicioTipo($id)
    {
        $servicio = Servicio::findOrFail($id);

        return response()->json($servicio->only('cod_tipo_servicio'));
    }

    public function tecnicosServicio($id)
    {
        $tecnicos = DB::table('tecnico')
            ->join('tecnico_servicio', 'tecnico.id', '=', 'tecnico_servicio.cod_tecnico')
            ->where('tecnico_servicio.cod_servicio', $id)
            ->distinct()
            ->select('tecnico.*')
            ->get();

        return response()->json($tecnicos);
    }
}
