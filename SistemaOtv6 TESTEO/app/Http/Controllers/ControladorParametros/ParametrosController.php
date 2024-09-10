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
use App\Models\TecnicoServicio; // Importa el modelo TecnicoServicio
use Illuminate\Http\Request;

class ParametrosController extends Controller
{
    // Muestra la lista de categorías, subcategorías, líneas, sublíneas, marcas, tipos de OT, prioridades de OT, estados de OT, tipos de visita, tipos de servicio, modelos, usuarios, técnicos, clientes, sucursales, contactos, servicios y técnico-servicios
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
            ->get(); // Consulta de técnico-servicios

        return view('parametros.parametros', compact('categorias', 'subcategorias', 'lineas', 'sublineas', 'marcas', 'tipos_ot', 'prioridades_ot', 'estados_ot', 'tipos_visita', 'tipos_servicio', 'modelos', 'usuarios', 'tecnicos', 'clientes', 'sucursales', 'contactos', 'servicios', 'tecnico_servicios', 'search'));
    }

    // Muestra el detalle de una entidad específica
    public function show($id)
    {
        $sublinea = Sublinea::with('linea')->findOrFail($id);
        return view('parametros.detalle', compact('sublinea'));
    }
}
