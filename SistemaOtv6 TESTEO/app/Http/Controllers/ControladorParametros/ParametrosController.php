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
use App\Models\Avance; // Importa el modelo Avance
use Illuminate\Http\Request;

class ParametrosController extends Controller
{
    // Muestra la lista de todas las entidades y busca según los criterios
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        // Consultas de cada modelo
        $categorias = Categoria::where('nombre_categoria', 'like', "%{$search}%")->get();
        $subcategorias = Subcategoria::with('categoria')
            ->where('nombre_subcategoria', 'like', "%{$search}%")
            ->get();
        $lineas = Linea::with('subcategoria')
            ->where('nombre_linea', 'like', "%{$search}%")
            ->get();
        $sublineas = Sublinea::with('linea')
            ->where('nombre_sublinea', 'like', "%{$search}%")
            ->get();
        $marcas = Marca::where('nombre_marca', 'like', "%{$search}%")->get();
        $tipos_ot = TipoOt::where('descripcion_tipo_ot', 'like', "%{$search}%")->get();
        $prioridades_ot = PrioridadOt::where('descripcion_prioridad_ot', 'like', "%{$search}%")->get();
        $estados_ot = EstadoOt::where('descripcion_estado_ot', 'like', "%{$search}%")->get();
        $tipos_visita = TipoVisita::where('descripcion_tipo_visita', 'like', "%{$search}%")->get();
        $tipos_servicio = TipoServicio::where('descripcion_tipo_servicio', 'like', "%{$search}%")->get();
        $modelos = Modelo::with('marca', 'sublinea')
            ->where('nombre_modelo', 'like', "%{$search}%")
            ->get();
        $usuarios = Usuario::where('nombre_usuario', 'like', "%{$search}%")
            ->orWhere('email_usuario', 'like', "%{$search}%")
            ->get();
        $tecnicos = Tecnico::with('usuario')
            ->where('nombre_tecnico', 'like', "%{$search}%")
            ->get();
        $clientes = Cliente::where('nombre_cliente', 'like', "%{$search}%")
            ->orWhere('email_cliente', 'like', "%{$search}%")
            ->get();
        $sucursales = Sucursal::with('cliente')
            ->where('nombre_sucursal', 'like', "%{$search}%")
            ->get();
        $contactos = Contacto::with('sucursal')
            ->where('nombre_contacto', 'like', "%{$search}%")
            ->get();
        $servicios = Servicio::with('tipoServicio', 'sublinea')
            ->where('nombre_servicio', 'like', "%{$search}%")
            ->get();
        $tecnico_servicios = TecnicoServicio::with('tecnico', 'servicio')
            ->get();
        $tareas = Tarea::with('servicio')
            ->where('nombre_tarea', 'like', "%{$search}%")
            ->get();
        $dispositivos = Dispositivo::with('modelo', 'sucursal')
            ->where('numero_serie_dispositivo', 'like', "%{$search}%")
            ->get();
        $dispositivos_ot = DispositivoOt::with('dispositivo', 'ot', 'detalles', 'accesorios')
            ->get();
        $tareas_ot = TareaOt::with('tarea', 'ot')
            ->get();
        $contactos_ot = ContactoOt::with('contacto', 'ot')
            ->get();
        $equipos_tecnicos = EquipoTecnico::with('tecnico', 'ot')
            ->get();
        $avances = Avance::with('ot')
            ->where('comentario_avance', 'like', "%{$search}%")
            ->get(); // Consulta de Avance

        return view('parametros.parametros', compact('categorias', 'subcategorias', 'lineas', 'sublineas', 'marcas', 'tipos_ot', 'prioridades_ot', 'estados_ot', 'tipos_visita', 'tipos_servicio', 'modelos', 'usuarios', 'tecnicos', 'clientes', 'sucursales', 'contactos', 'servicios', 'tecnico_servicios', 'tareas', 'dispositivos', 'dispositivos_ot', 'tareas_ot', 'contactos_ot', 'equipos_tecnicos', 'avances', 'search'));
    }

    // Muestra el detalle de una entidad específica
    public function show($id)
    {
        $avance = Avance::with('ot')->findOrFail($id);
        return view('parametros.detalle', compact('avance'));
    }
}
