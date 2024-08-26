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
        // Obtener los filtros de la solicitud
        $categoriaId = $request->input('categoria');
        $subcategoriaId = $request->input('subcategoria');
        $lineaId = $request->input('linea');
        $sublineaId = $request->input('sublinea');
        $marcaId = $request->input('marca');
        $modeloId = $request->input('modelo');

        // Inicializar la consulta
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
            $query->where('marca_id', $marcaId);
        }
        if ($modeloId) {
            $query->where('id', $modeloId);
        }

        // Ordenar y paginar los resultados
        $modelos = $query->orderBy('id', 'desc')->paginate(50); // Ajusta el número de elementos por página según tus necesidades

        // Obtener los datos para los filtros
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $lineas = Linea::all();
        $sublineas = Sublinea::all();
        $marcas = Marca::all();

        return view('modelos.modelos', compact('modelos', 'categorias', 'subcategorias', 'lineas', 'sublineas', 'marcas'));
    }
}
