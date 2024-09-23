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
    // Muestra la lista de modelos con filtros y paginación
    public function index(Request $request)
    {
        return $this->handleRequest($request);
    }

    // Realiza búsqueda de los modelos según un término dado
    public function buscar(Request $request)
    {
        // Actualizar el parámetro de búsqueda con un valor por defecto si está vacío
        $request->merge(['search' => $request->input('search', '')]);
        return $this->handleRequest($request);
    }

    // Muestra el detalle de un modelo específico
    public function show($id)
    {
        $modelo = Modelo::with(['sublinea.linea.subcategoria.categoria', 'marca', 'dispositivos.sucursal'])
            ->findOrFail($id);
        $modelosRelacionados = Modelo::where('id', '!=', $id)->get();
        return view('modelos.detalle', compact('modelo', 'modelosRelacionados'));
    }

    // Muestra el formulario para crear un nuevo modelo
    public function create()
    {
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        $lineas = Linea::all();
        $sublineas = Sublinea::all();
        $marcas = Marca::all();

        return view('modelos.agregar', compact('categorias', 'subcategorias', 'lineas', 'sublineas', 'marcas'));
    }


    // Almacena un nuevo modelo en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre_modelo' => 'required|string|max:255',
            'part_number_modelo' => 'nullable|string|max:255',
            'desc_corta_modelo' => 'nullable|string',
            'desc_larga_modelo' => 'nullable|string',
            'cod_categoria' => 'required|integer',
            'cod_subcategoria' => 'required|integer',
            'cod_linea' => 'required|integer',
            'cod_sublinea' => 'required|integer',
            'cod_marca' => 'required|integer',
        ]);

        Modelo::create($request->all());

        return redirect()->route('modelos.index')->with('success', 'Modelo agregado con éxito.');
    }

    public function edit($id)
    {
        // Obtener el modelo junto con sus relaciones
        $modelo = Modelo::with(['sublinea.linea.subcategoria.categoria', 'marca'])->findOrFail($id);

        // Obtener todas las categorías
        $categorias = Categoria::all();

        // Obtener subcategorías, líneas y sublíneas basadas en el modelo actual
        $subcategorias = Subcategoria::where('cod_categoria', $modelo->sublinea->linea->subcategoria->cod_categoria)->get();
        $lineas = Linea::where('cod_subcategoria', $modelo->sublinea->linea->cod_subcategoria)->get();
        $sublineas = Sublinea::where('cod_linea', $modelo->sublinea->cod_linea)->get();

        // Obtener todas las marcas
        $marcas = Marca::all();

        return view('modelos.editar', compact('modelo', 'categorias', 'subcategorias', 'lineas', 'sublineas', 'marcas'));
    }



    // Actualiza un modelo existente en la base de datos
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_modelo' => 'required|string|max:255',
            'part_number_modelo' => 'nullable|string|max:255',
            'desc_corta_modelo' => 'nullable|string',
            'desc_larga_modelo' => 'nullable|string',
            'cod_categoria' => 'required|integer',
            'cod_subcategoria' => 'required|integer',
            'cod_linea' => 'required|integer',
            'cod_sublinea' => 'required|integer',
            'cod_marca' => 'required|integer',
        ]);

        $modelo = Modelo::findOrFail($id);
        $modelo->update($request->all());

        return redirect()->route('modelos.index')->with('success', 'Modelo actualizado con éxito.');
    }

    // Elimina un modelo existente de la base de datos
    public function destroy($id)
    {
        $modelo = Modelo::findOrFail($id);
        $modelo->delete();

        return redirect()->route('modelos.index')->with('success', 'Modelo eliminado con éxito.');
    }

    // Obtiene las subcategorías según la categoría seleccionada (AJAX)
    public function getSubcategorias($categoriaId)
    {
        $subcategorias = Subcategoria::where('cod_categoria', $categoriaId)->get();
        return response()->json($subcategorias);
    }

    // Obtiene las líneas según la subcategoría seleccionada (AJAX)
    public function getLineas($subcategoriaId)
    {
        $lineas = Linea::where('cod_subcategoria', $subcategoriaId)->get();
        return response()->json($lineas);
    }

    // Obtiene las sublíneas según la línea seleccionada (AJAX)
    public function getSublineas($lineaId)
    {
        $sublineas = Sublinea::where('cod_linea', $lineaId)->get();
        return response()->json($sublineas);
    }

    private function handleRequest(Request $request)
    {
        $categoriaId = $request->input('categoria');
        $subcategoriaId = $request->input('subcategoria');
        $lineaId = $request->input('linea');
        $sublineaId = $request->input('sublinea');
        $marcaId = $request->input('marca');
        $modeloId = $request->input('modelo');
        $search = $request->input('search');

        $query = Modelo::query();

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
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhere('nombre_modelo', 'like', "%{$search}%")
                    ->orWhere('part_number_modelo', 'like', "%{$search}%")
                    ->orWhere('desc_corta_modelo', 'like', "%{$search}%")
                    ->orWhere('desc_larga_modelo', 'like', "%{$search}%");
            });
        }

        // Obtener y paginar los resultados
        $modelos = $query->orderBy('id', 'desc')->paginate(50);

        $categorias = Categoria::all();
        $subcategorias = $categoriaId ? Subcategoria::where('cod_categoria', $categoriaId)->get() : Subcategoria::all();
        $lineas = $subcategoriaId ? Linea::where('cod_subcategoria', $subcategoriaId)->get() : Linea::all();
        $sublineas = $lineaId ? Sublinea::where('cod_linea', $lineaId)->get() : Sublinea::all();
        $marcas = $sublineaId ? Marca::whereIn('id', function ($query) use ($sublineaId) {
            $query->select('cod_marca')
                ->from('modelo')
                ->where('cod_sublinea', $sublineaId);
        })->get() : Marca::all();

        // Contar los resultados de las tablas
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

        return view('modelos.modelos', compact(
            'modelos',
            'categorias',
            'subcategorias',
            'lineas',
            'sublineas',
            'marcas',
            'subcategoriaCounts',
            'lineaCounts',
            'sublineaCounts',
            'marcaCounts'
        ));
    }
}
