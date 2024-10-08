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
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Validator;

class OrdenesController extends Controller
{
    public function index(Request $request)
    {
        // Obtiene el valor del parámetro 'show_all', por defecto es 'false' (órdenes asignadas)
        $showAll = $request->input('show_all', 'false');

        // Obtiene el usuario autenticado
        $usuario = Auth::user();

        // Verifica si el usuario tiene el permiso para alternar vistas
        $puedeCambiarVista = $usuario->can('ordenes.toggle_view');

        // Inicializa la variable para el técnico
        $tecnico = null;

        // Inicializa la variable de órdenes
        $ordenes = collect();

        // Verifica si el usuario tiene un técnico asociado
        if ($usuario && $usuario->tecnico) {
            $tecnico = $usuario->tecnico;

            // Verifica si el usuario seleccionó mostrar todas las órdenes y tiene el permiso
            if ($showAll === 'true' && $puedeCambiarVista) {
                // Si el usuario tiene permiso y seleccionó mostrar todas las órdenes
                $ordenes = Ot::with([
                    'contacto',
                    'servicio',
                    'tecnicoEncargado',
                    'estado',
                    'prioridad',
                    'tipo',
                    'tipoVisita',
                    'contactoOt'
                ])
                    ->orderBy('created_at', 'desc')
                    ->paginate(50)
                    ->appends(['show_all' => $showAll]); // Agrega 'show_all' a la paginación
            } else {
                // Obtiene las órdenes asignadas a este técnico
                $ordenes = Ot::where('cod_tecnico_encargado', $tecnico->id)
                    ->with([
                        'contacto',
                        'servicio',
                        'tecnicoEncargado',
                        'estado',
                        'prioridad',
                        'tipo',
                        'tipoVisita',
                        'contactoOt'
                    ])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10)
                    ->appends(['show_all' => $showAll]); // Agrega 'show_all' a la paginación
            }
        } else {
            // Si el usuario no tiene un técnico asociado, mostrar todas las órdenes si tiene el permiso
            if ($puedeCambiarVista) {
                $ordenes = Ot::with([
                    'contacto',
                    'servicio',
                    'tecnicoEncargado',
                    'estado',
                    'prioridad',
                    'tipo',
                    'tipoVisita',
                    'contactoOt'
                ])
                    ->orderBy('created_at', 'desc')
                    ->paginate(50)
                    ->appends(['show_all' => $showAll]); // Agrega 'show_all' a la paginación
            }
        }

        // Selecciona la vista para marcar en el formulario
        $vistaSeleccionada = $showAll === 'true' ? 'todas' : 'asignadas';

        // Retorna la vista con los datos necesarios
        return view('ordenes.ordenes', compact('ordenes', 'vistaSeleccionada', 'tecnico', 'puedeCambiarVista'));
    }





    public function obtenerOrden($id)
    {
        $orden = Ot::with([
            'contacto',
            'contacto.sucursal',
            'contacto.sucursal.cliente',
            'servicio',
            'tecnicoEncargado',
            'estado',
            'prioridad',
            'tipo',
            'tipoVisita',
            'contactoOt',
            'contactoOt.contacto',
            'contactoOt.contacto.sucursal',
            'contactoOt.contacto.sucursal.cliente',
            'tareasOt',
            'dispositivoOt',
            'dispositivoOt.detalles',
            'dispositivoOt.accesorios',
            'dispositivoOt.tareaDispositivo',
            'equipoTecnico'
        ])
            ->findOrFail($id);

        return response()->json($orden);
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

    public function edit($id)
    {
        $tipos = TipoOt::all();
        $prioridades = PrioridadOt::all();
        $estados = EstadoOt::all();
        $tiposVisitas = TipoVisita::all();
        $tecnicos = Tecnico::all();
        $clientes = Cliente::all();
        $servicios = Servicio::all();

        $orden = Ot::with([
            'contacto',
            'contacto.sucursal',
            'contacto.sucursal.cliente',
            'servicio',
            'tecnicoEncargado',
            'estado',
            'prioridad',
            'tipo',
            'tipoVisita',
            'contactoOt',
            'contactoOt.contacto',
            'contactoOt.contacto.sucursal',
            'contactoOt.contacto.sucursal.cliente',
            'tareasOt',
            'dispositivoOt',
            'dispositivoOt.detalles',
            'dispositivoOt.accesorios',
            'dispositivoOt.tareaDispositivo',
            'equipoTecnico'
        ])
            ->findOrFail($id);


        return view('ordenes.editar', compact('tipos', 'prioridades', 'estados', 'tiposVisitas', 'tecnicos', 'clientes', 'servicios', 'orden'));
    }

    public function store(Request $request)
    {
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
        } elseif ($datosValidados['tipoServicio'] == 2) {
            for ($i = 0; $i < $datosValidados['contadorBloques']; $i++) {
                if (isset($datosValidados['tareasDispositivos-' . $i])) {
                    $skipFirst = true;
                    foreach ($datosValidados['tareasDispositivos-' . $i] as $tarea) {
                        if ($skipFirst) {
                            $skipFirst = false;
                            continue;
                        }
                        $tiempoTarea = Tarea::find($tarea)->tiempo_tarea;
                        $tiempoEnMinutos += $tiempoTarea;
                    }
                }
            }
        }

        $tiempoEnHoras = ceil($tiempoEnMinutos / 60);

        //6 HORAS DIARIAS
        $diasTrabajo = ceil($tiempoEnHoras / 6);

        $fecha_inicio = $datosValidados['fecha'];

        try {
            $selectedDate = new DateTime($fecha_inicio);
        } catch (Exception $e) {
            echo ('La fecha seleccionada no es válidas.');
            return;
        }

        try {
            // Obtener días feriados desde la API
            $feriados = self::obtener_feriados_chile();

            // Calcular la fecha estimada de fin de la OT
            $fecha_fin_estimada = self::add_business_days($selectedDate, $diasTrabajo, $feriados);
            $fecha_fin_estimada = $fecha_fin_estimada->format('Y-m-d');

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
            $ot->fecha_fin_planificada_ot = $fecha_fin_estimada;
            $ot->save();

            $idOt = $ot->id;
            foreach ($datosValidados['contactos'] as $contacto) {
                $ot->contactoOt()->create([
                    'cod_ot' => $idOt,
                    'cod_contacto' => $contacto,
                ]);
            }
            foreach ($datosValidados['tecnicos'] as $tecnico) {
                $ot->EquipoTecnico()->create([
                    'cod_ot' => $idOt,
                    'cod_tecnico' => $tecnico,
                ]);
            }

            if ($datosValidados['tipoServicio'] == 1) {

                foreach ($datosValidados['tareasSinD'] as $tarea) {
                    $ot->TareasOt()->create([
                        'cod_ot' => $idOt,
                        'cod_tarea' => $tarea,
                    ]);
                }
            } elseif ($datosValidados['tipoServicio'] == 2) {

                foreach ($datosValidados['dispositivos'] as $dispositivo) {
                    $dispositivoOt = $ot->DispositivoOT()->create([
                        'cod_ot' => $idOt,
                        'cod_dispositivo' => $dispositivo,
                    ]);

                    for ($i = 0; $i < $datosValidados['contadorBloques']; $i++) {
                        if (isset($datosValidados['tareasDispositivos-' . $i])) {
                            if ($datosValidados['tareasDispositivos-' . $i][0] == $dispositivo) {
                                foreach ($datosValidados['tareasDispositivos-' . $i] as $tarea) {
                                    if ($tarea != $dispositivo) {
                                        $dispositivoOt->tareaDispositivo()->create([
                                            'cod_dispositivo_ot' =>  $dispositivoOt->id,
                                            'cod_tarea' => $tarea,
                                        ]);
                                    }
                                }
                            }
                        }

                        if (isset($datosValidados['detallesDispositivo-' . $i])) {
                            if ($datosValidados['detallesDispositivo-' . $i]['existe'] == 1) {
                                if ($datosValidados['detallesDispositivo-' . $i]['dispositivo'] == $dispositivo) {
                                    $dispositivoOt->detalles()->create([
                                        'rayones_det' => $datosValidados['detallesDispositivo-' . $i]['rayones'],
                                        'rupturas_det' => $datosValidados['detallesDispositivo-' . $i]['rupturas'],
                                        'tornillos_det' => $datosValidados['detallesDispositivo-' . $i]['tornillos'],
                                        'gomas_det' => $datosValidados['detallesDispositivo-' . $i]['gomas'],
                                        'estado_dispositivo_det' => $datosValidados['detallesDispositivo-' . $i]['estado'],
                                        'observaciones_det' => $datosValidados['detallesDispositivo-' . $i]['observaciones'],
                                        'cod_dispositivo_ot' =>  $dispositivoOt->id,
                                    ]);
                                }
                            }
                        }

                        if (isset($datosValidados['accesoriosDispositivo-' . $i])) {
                            if ($datosValidados['accesoriosDispositivo-' . $i]['existe'] == 1) {
                                if ($datosValidados['accesoriosDispositivo-' . $i]['dispositivo'] == $dispositivo) {
                                    $dispositivoOt->accesorios()->create([
                                        'cargador_acc' => $datosValidados['accesoriosDispositivo-' . $i]['cargador'],
                                        'cable_acc' => $datosValidados['accesoriosDispositivo-' . $i]['cablePoder'],
                                        'adaptador_acc' => $datosValidados['accesoriosDispositivo-' . $i]['adaptadorPoder'],
                                        'bateria_acc' => $datosValidados['accesoriosDispositivo-' . $i]['bateria'],
                                        'pantalla_acc' => $datosValidados['accesoriosDispositivo-' . $i]['pantalla'],
                                        'teclado_acc' => $datosValidados['accesoriosDispositivo-' . $i]['teclado'],
                                        'drum_acc' => $datosValidados['accesoriosDispositivo-' . $i]['drum'],
                                        'toner_acc' => $datosValidados['accesoriosDispositivo-' . $i]['toner'],
                                        'cod_dispositivo_ot' =>  $dispositivoOt->id,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            return response()->json(['message' => 'Orden de trabajo creada correctamente!'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al crear la orden de trabajo ', 'errors' => $validator->errors()], 422);
            // return redirect()->back()->withErrors($validator)->withInput();
            // return redirect()->route('ordenes.index')->with('error', 'Error al crear la orden de trabajo.');
        }
    }

    public function update(Request $request, $id)
    {
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
        } elseif ($datosValidados['tipoServicio'] == 2) {
            for ($i = 0; $i < $datosValidados['contadorBloques']; $i++) {
                if (isset($datosValidados['tareasDispositivos-' . $i])) {
                    $skipFirst = true;
                    foreach ($datosValidados['tareasDispositivos-' . $i] as $tarea) {
                        if ($skipFirst) {
                            $skipFirst = false;
                            continue;
                        }
                        $tiempoTarea = Tarea::find($tarea)->tiempo_tarea;
                        $tiempoEnMinutos += $tiempoTarea;
                    }
                }
            }
        }

        $tiempoEnHoras = ceil($tiempoEnMinutos / 60);

        //6 HORAS DIARIAS

        $diasTrabajo = ceil($tiempoEnHoras / 6);

        $fecha_inicio = $datosValidados['fecha'];

        try {
            $selectedDate = new DateTime($fecha_inicio);
        } catch (Exception $e) {
            echo ('La fecha seleccionada no es válidas.');
            return;
        }

        $ot = Ot::findOrFail($id);

        try {
            // Obtener días feriados desde la API
            $feriados = self::obtener_feriados_chile();

            // Calcular la fecha estimada de fin de la OT
            $fecha_fin_estimada = self::add_business_days($selectedDate, $diasTrabajo, $feriados);
            $fecha_fin_estimada = $fecha_fin_estimada->format('Y-m-d');


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
            $ot->fecha_fin_planificada_ot = $fecha_fin_estimada;
            $ot->save();

            $ot->contactoOt()->delete();
            $ot->EquipoTecnico()->delete();
            $ot->TareasOt()->delete();
            $ot->DispositivoOt()->delete();

            foreach ($datosValidados['contactos'] as $contacto) {
                $ot->contactoOt()->create([
                    'cod_ot' => $id,
                    'cod_contacto' => $contacto,
                ]);
            }
            foreach ($datosValidados['tecnicos'] as $tecnico) {
                $ot->EquipoTecnico()->create([
                    'cod_ot' => $id,
                    'cod_tecnico' => $tecnico,
                ]);
            }

            if ($datosValidados['tipoServicio'] == 1) {

                foreach ($datosValidados['tareasSinD'] as $tarea) {
                    $ot->TareasOt()->create([
                        'cod_ot' => $id,
                        'cod_tarea' => $tarea,
                    ]);
                }
            } elseif ($datosValidados['tipoServicio'] == 2) {

                foreach ($datosValidados['dispositivos'] as $dispositivo) {
                    $dispositivoOt = $ot->DispositivoOT()->create([
                        'cod_ot' => $id,
                        'cod_dispositivo' => $dispositivo,
                    ]);

                    for ($i = 0; $i < $datosValidados['contadorBloques']; $i++) {
                        if (isset($datosValidados['tareasDispositivos-' . $i])) {
                            if ($datosValidados['tareasDispositivos-' . $i][0] == $dispositivo) {
                                foreach ($datosValidados['tareasDispositivos-' . $i] as $tarea) {
                                    if ($tarea != $dispositivo) {
                                        $dispositivoOt->tareaDispositivo()->create([
                                            'cod_dispositivo_ot' =>  $dispositivoOt->id,
                                            'cod_tarea' => $tarea,
                                        ]);
                                    }
                                }
                            }
                        }

                        if (isset($datosValidados['detallesDispositivo-' . $i])) {
                            if ($datosValidados['detallesDispositivo-' . $i]['existe'] == 1) {
                                if ($datosValidados['detallesDispositivo-' . $i]['dispositivo'] == $dispositivo) {
                                    $dispositivoOt->detalles()->create([
                                        'rayones_det' => $datosValidados['detallesDispositivo-' . $i]['rayones'],
                                        'rupturas_det' => $datosValidados['detallesDispositivo-' . $i]['rupturas'],
                                        'tornillos_det' => $datosValidados['detallesDispositivo-' . $i]['tornillos'],
                                        'gomas_det' => $datosValidados['detallesDispositivo-' . $i]['gomas'],
                                        'estado_dispositivo_det' => $datosValidados['detallesDispositivo-' . $i]['estado'],
                                        'observaciones_det' => $datosValidados['detallesDispositivo-' . $i]['observaciones'],
                                        'cod_dispositivo_ot' =>  $dispositivoOt->id,
                                    ]);
                                }
                            }
                        }

                        if (isset($datosValidados['accesoriosDispositivo-' . $i])) {
                            if ($datosValidados['accesoriosDispositivo-' . $i]['existe'] == 1) {
                                if ($datosValidados['accesoriosDispositivo-' . $i]['dispositivo'] == $dispositivo) {
                                    $dispositivoOt->accesorios()->create([
                                        'cargador_acc' => $datosValidados['accesoriosDispositivo-' . $i]['cargador'],
                                        'cable_acc' => $datosValidados['accesoriosDispositivo-' . $i]['cablePoder'],
                                        'adaptador_acc' => $datosValidados['accesoriosDispositivo-' . $i]['adaptadorPoder'],
                                        'bateria_acc' => $datosValidados['accesoriosDispositivo-' . $i]['bateria'],
                                        'pantalla_acc' => $datosValidados['accesoriosDispositivo-' . $i]['pantalla'],
                                        'teclado_acc' => $datosValidados['accesoriosDispositivo-' . $i]['teclado'],
                                        'drum_acc' => $datosValidados['accesoriosDispositivo-' . $i]['drum'],
                                        'toner_acc' => $datosValidados['accesoriosDispositivo-' . $i]['toner'],
                                        'cod_dispositivo_ot' =>  $dispositivoOt->id,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }


            return response()->json(['message' => 'Orden de trabajo actualizada correctamente!'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al actualizar la orden de trabajo ', 'errors' => $validator->errors()], 422);
            return;
        }
    }


    public static function obtener_feriados_chile()
    {
        $feriados = Cache::get('feriados_chilev2');

        if (!$feriados) {
            $response = Http::withOptions(['verify' => false])->get('https://apis.digital.gob.cl/fl/feriados/' . date("Y"));

            if ($response->status() != 200) {
                return []; // Si hay un error, retorna un array vacío
            }

            $feriados = $response->json(); // Decodifica la respuesta JSON

            if (empty($feriados)) {
                return [];
            }

            $feriado_fechas = array_map(function ($feriado) {
                return $feriado['fecha'];
            }, $feriados);

            // Puedes guardar los datos en una opción transitoria para cachear los resultados
            Cache::put('feriados_chilev2', $feriado_fechas, 86400); // 86400 is the number of seconds in a day
            return $feriado_fechas;
        }
        return $feriados;
    }


    function add_business_days($date, $days, $holidays)
    {
        $count = 0;
        $result = clone $date;

        while ($count < $days) {
            $result->modify('+1 day');
            $weekday = $result->format('N'); // 1 para Lunes, 7 para Domingo

            if ($weekday < 6 && !in_array($result->format('Y-m-d'), $holidays)) {
                $count++;
            }
        }

        return $result;
    }


    public function buscar(Request $request)
    {
        $search = $request->input('search');
        $showAll = $request->input('show_all', 'false'); // Obtiene el valor de show_all

        // Obtiene el usuario autenticado
        $usuario = Auth::user();

        // Verifica si el usuario tiene el permiso para alternar vistas
        $puedeCambiarVista = $usuario->can('ordenes.toggle_view');

        // Inicializa la consulta base
        $query = Ot::with([
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
        ]);

        // Si el usuario no tiene permiso para ver todas las órdenes, filtramos por técnico
        if (!$puedeCambiarVista && $usuario->tecnico) {
            $query->where('cod_tecnico_encargado', $usuario->tecnico->id);
        }

        // Aplicar filtros de búsqueda dependiendo de la vista seleccionada
        if ($showAll === 'true') {
            // Solo aplicar filtros si el usuario está buscando en la vista de "todas las órdenes"
            $query->where(function ($query) use ($search) {
                $query->where('numero_ot', 'like', "%$search%")
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
                    });
            });
        } else {
            // Si está en la vista de "órdenes asignadas", solo se aplican filtros a las órdenes del técnico
            if ($usuario->tecnico) {
                $query->where('cod_tecnico_encargado', $usuario->tecnico->id);
            }

            // Aplicar filtros de búsqueda
            $query->where(function ($query) use ($search) {
                $query->where('numero_ot', 'like', "%$search%")
                    ->orWhere('descripcion_ot', 'like', "%$search%")
                    ->orWhere('cotizacion', 'like', "%$search%")
                    ->orWhereHas('contacto', function ($query) use ($search) {
                        $query->where('nombre_contacto', 'like', "%$search%");
                    });
                // Aquí se podrían agregar más condiciones si es necesario.
            });
        }

        // Obtiene las órdenes paginadas
        $ordenes = $query->orderBy('numero_ot', 'desc')->paginate(50);

        // Selecciona la vista para marcar en el formulario
        $vistaSeleccionada = $showAll === 'true' ? 'todas' : 'asignadas';

        return view('ordenes.ordenes', compact('ordenes', 'vistaSeleccionada', 'puedeCambiarVista'));
    }





    public function show($id)
    {
        // Obtiene el usuario autenticado
        $usuario = Auth::user();

        // Encuentra la OT con sus relaciones
        $orden = Ot::with([
            'contacto',
            'servicio',
            'tecnicoEncargado',
            'estado',
            'prioridad',
            'tipo',
            'tipoVisita',
            'contactoOt'
        ])->findOrFail($id);

        // Verifica si el usuario tiene el permiso para ver todas las órdenes
        if (!$usuario->can('ordenes.toggle_view')) {
            // Si el usuario no tiene permiso, verifica si la OT está asignada al técnico del usuario
            if ($usuario->tecnico && $orden->cod_tecnico_encargado !== $usuario->tecnico->id) {
                // Si la OT no está asignada al técnico, redirige o muestra un mensaje de error
                abort(403, 'No tienes permiso para ver esta orden.');
            }
        }

        // Retorna la vista con la OT
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
