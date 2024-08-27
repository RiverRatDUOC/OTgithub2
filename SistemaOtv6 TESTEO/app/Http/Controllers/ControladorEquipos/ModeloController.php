<?php

namespace App\Http\Controllers\ControladorEquipos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modelo;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Linea;
use App\Models\Sublinea;
use App\Models\Marca;

class ModeloController extends Controller
{
    public function index(Request $request)
    {
        return $this->handleRequest($request);
    }

    public function buscar(Request $request)
    {
        // Actualizar el parámetro de búsqueda con un valor por defecto si está vacío
        $request->merge(['search' => $request->input('search', '')]);

        return $this->handleRequest($request);
    }

    private function handleRequest(Request $request)
    {
        // Obtener los filtros de la solicitud
        $categoriaId = $request->input('categoria');
        $subcategoriaId = $request->input('subcategoria');
        $lineaId = $request->input('linea');
        $sublineaId = $request->input('sublinea');
        $marcaId = $request->input('marca');
        $modeloId = $request->input('modelo');
        $search = $request->input('search');

        // Inicializar la consulta de modelos
        $query = Modelo::query();

        // Aplicar filtros
        if ($categoriaId) {
            $query->whereHas('sublinea.linea.subcategoria.categoria', function ($q) use ($categoriaId) {
                $q->where('id', $categoriaId);
            });
        }
        if ($subcategoriaId) {
            $query->whereHas('sublinea.linea.subcategoria', function ($q) use ($subcategoriaId) {
                $q->where('id', $subcategoriaId);
            });
        }
        if ($lineaId) {
            $query->whereHas('sublinea.linea', function ($q) use ($lineaId) {
                $q->where('id', $lineaId);
            });
        }
        if ($sublineaId) {
            $query->where('cod_sublinea', $sublineaId);
        }
        if ($marcaId) {
            $query->where('cod_marca', $marcaId);
        }
        if ($modeloId) {
            $query->where('id', $modeloId);
        }

        // Aplicar búsqueda
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                  ->orWhere('nombre_modelo', 'like', "%{$search}%")
                  ->orWhere('part_number_modelo', 'like', "%{$search}%")
                  ->orWhere('desc_corta_modelo', 'like', "%{$search}%");
            });
        }

        // Ordenar y paginar los resultados
        $modelos = $query->orderBy('id', 'desc')->paginate(50);

        // Obtener los datos para los filtros
        $categorias = Categoria::all();
        $subcategorias = $categoriaId ? Subcategoria::where('cod_categoria', $categoriaId)->get() : Subcategoria::all();
        $lineas = $subcategoriaId ? Linea::where('cod_subcategoria', $subcategoriaId)->get() : Linea::all();
        $sublineas = $lineaId ? Sublinea::where('cod_linea', $lineaId)->get() : Sublinea::all();
        $marcas = $sublineaId ? Marca::whereIn('id', function ($query) use ($sublineaId) {
            $query->select('cod_marca')
                ->from('modelo')
                ->where('cod_sublinea', $sublineaId);
        })->get() : Marca::all();

        // Contar modelos para cada filtro
        $subcategoriaCounts = Subcategoria::select('id')
            ->get()
            ->mapWithKeys(function ($subcategoria) {
                return [$subcategoria->id => Modelo::whereHas('sublinea.linea', function ($query) use ($subcategoria) {
                    $query->where('cod_subcategoria', $subcategoria->id);
                })->count()];
            });

        $lineaCounts = Linea::select('id')
            ->get()
            ->mapWithKeys(function ($linea) {
                return [$linea->id => Modelo::whereHas('sublinea', function ($query) use ($linea) {
                    $query->where('cod_linea', $linea->id);
                })->count()];
            });

        $sublineaCounts = Sublinea::select('id')
            ->get()
            ->mapWithKeys(function ($sublinea) {
                return [$sublinea->id => Modelo::where('cod_sublinea', $sublinea->id)->count()];
            });

        $marcaCounts = Marca::select('id')
            ->get()
            ->mapWithKeys(function ($marca) {
                return [$marca->id => Modelo::where('cod_marca', $marca->id)->count()];
            });

        return view('modelos.modelos', compact('modelos', 'categorias', 'subcategorias', 'lineas', 'sublineas', 'marcas', 'subcategoriaCounts', 'lineaCounts', 'sublineaCounts', 'marcaCounts'));
    }
}
