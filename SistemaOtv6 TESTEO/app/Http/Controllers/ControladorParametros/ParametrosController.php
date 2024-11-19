<?php

namespace App\Http\Controllers\ControladorParametros;

use App\Http\Controllers\Controller;
use App\Models\Sublinea;
use App\Models\Linea;
use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\TipoOt;
use App\Models\PrioridadOt;
use App\Models\EstadoOt;
use App\Models\TipoVisita;
use App\Models\TipoServicio;
use App\Models\Modelo;
use App\Models\Usuario;
use App\Models\Tecnico;
use App\Models\Cliente;
use App\Models\Sucursal;
use App\Models\Contacto;
use App\Models\Servicio;
use App\Models\TecnicoServicio;
use App\Models\Tarea;
use App\Models\Dispositivo;
use App\Models\DispositivoOt;
use App\Models\TareaOt;
use App\Models\ContactoOt;
use App\Models\EquipoTecnico;
use App\Models\Avance;
use Illuminate\Http\Request;

class ParametrosController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $categorias = Categoria::where('nombre_categoria', 'like', "%{$search}%")->paginate(10);
        $subcategorias = Subcategoria::with('categoria')
            ->where('nombre_subcategoria', 'like', "%{$search}%")
            ->paginate(10);
        $lineas = Linea::with('subcategoria')
            ->where('nombre_linea', 'like', "%{$search}%")
            ->paginate(10);
        $sublineas = Sublinea::with('linea')
            ->where('nombre_sublinea', 'like', "%{$search}%")
            ->paginate(10);
        $marcas = Marca::where('nombre_marca', 'like', "%{$search}%")->paginate(10);
        $tipos_ot = TipoOt::where('descripcion_tipo_ot', 'like', "%{$search}%")->paginate(10);
        $prioridades_ot = PrioridadOt::where('descripcion_prioridad_ot', 'like', "%{$search}%")->paginate(10);
        $estados_ot = EstadoOt::where('descripcion_estado_ot', 'like', "%{$search}%")->paginate(10);
        $tipos_visita = TipoVisita::where('descripcion_tipo_visita', 'like', "%{$search}%")->paginate(10);
        $tipos_servicio = TipoServicio::where('descripcion_tipo_servicio', 'like', "%{$search}%")->paginate(10);
        $modelos = Modelo::with('marca', 'sublinea')
            ->where('nombre_modelo', 'like', "%{$search}%")
            ->paginate(10);
        $usuarios = Usuario::where('nombre_usuario', 'like', "%{$search}%")
            ->orWhere('email_usuario', 'like', "%{$search}%")
            ->paginate(10);
        $tecnicos = Tecnico::with('usuario')
            ->where('nombre_tecnico', 'like', "%{$search}%")
            ->paginate(10);
        $clientes = Cliente::where('nombre_cliente', 'like', "%{$search}%")
            ->orWhere('email_cliente', 'like', "%{$search}%")
            ->paginate(10);
        $sucursales = Sucursal::with('cliente')
            ->where('nombre_sucursal', 'like', "%{$search}%")
            ->paginate(10);
        $contactos = Contacto::with('sucursal')
            ->where('nombre_contacto', 'like', "%{$search}%")
            ->paginate(10);
        $servicios = Servicio::with('tipoServicio', 'sublinea')
            ->where('nombre_servicio', 'like', "%{$search}%")
            ->paginate(10);
        $tecnico_servicios = TecnicoServicio::with('tecnico', 'servicio')->paginate(10);
        $tareas = Tarea::with('servicio')
            ->where('nombre_tarea', 'like', "%{$search}%")
            ->paginate(10);
        $dispositivos = Dispositivo::with('modelo', 'sucursal')
            ->where('numero_serie_dispositivo', 'like', "%{$search}%")
            ->paginate(10);
        $dispositivos_ot = DispositivoOt::with('dispositivo', 'ot', 'detalles', 'accesorios')->paginate(10);
        $tareas_ot = TareaOt::with('tarea', 'ot')->paginate(10);
        $contactos_ot = ContactoOt::with('contacto', 'ot')->paginate(10);
        $equipos_tecnicos = EquipoTecnico::with('tecnico', 'ot')->paginate(10);
        $avances = Avance::with('ot')
            ->where('comentario_avance', 'like', "%{$search}%")
            ->paginate(10);

        return view('parametros.parametros', compact(
            'categorias',
            'subcategorias',
            'lineas',
            'sublineas',
            'marcas',
            'tipos_ot',
            'prioridades_ot',
            'estados_ot',
            'tipos_visita',
            'tipos_servicio',
            'modelos',
            'usuarios',
            'tecnicos',
            'clientes',
            'sucursales',
            'contactos',
            'servicios',
            'tecnico_servicios',
            'tareas',
            'dispositivos',
            'dispositivos_ot',
            'tareas_ot',
            'contactos_ot',
            'equipos_tecnicos',
            'avances',
            'search'
        ));
    }

    public function show($id)
    {
        $avance = Avance::with('ot')->findOrFail($id);
        return view('parametros.detalle', compact('avance'));
    }
}
