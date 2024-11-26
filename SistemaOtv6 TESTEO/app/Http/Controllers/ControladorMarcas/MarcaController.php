<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    // Muestra la lista de marcas con paginación
    public function index()
    {
        $marcas = Marca::paginate(10); // Paginación para mejor rendimiento
        return view('marca.index', compact('marcas'));
    }

    // Muestra el formulario para crear una nueva marca
    public function create()
    {
        return view('marca.agregar');
    }

    // Almacena una nueva marca en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre_marca' => 'required|string|max:255|unique:marca,nombre_marca', // Validación de unicidad
        ]);

        Marca::create($request->only('nombre_marca'));

        return redirect()->route('marcas.index')->with('success', 'Marca creada exitosamente');
    }

    // Muestra el detalle de una marca específica
    public function show($id)
    {
        $marca = Marca::findOrFail($id);
        return view('marca.detalle', compact('marca'));
    }

    // Muestra el formulario para editar una marca
    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        return view('marca.editar', compact('marca'));
    }

    // Actualiza una marca existente en la base de datos
    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);

        $request->validate([
            'nombre_marca' => 'required|string|max:255|unique:marca,nombre_marca,' . $marca->id, // Validación de unicidad, ignorando el ID actual
        ]);

        $marca->update($request->only('nombre_marca'));

        return redirect()->route('marcas.index')->with('success', 'Marca actualizada exitosamente');
    }

    // Elimina (suavemente) una marca de la base de datos
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete(); // Soft delete, gracias a SoftDeletes en el modelo

        return redirect()->route('marcas.index')->with('success', 'Marca eliminada exitosamente');
    }

    // Restaurar una marca eliminada suavemente
    public function restore($id)
    {
        $marca = Marca::onlyTrashed()->findOrFail($id);
        $marca->restore();

        return redirect()->route('marcas.index')->with('success', 'Marca restaurada exitosamente');
    }

    // Mostrar las marcas eliminadas suavemente
    public function trashed()
    {
        $marcas = Marca::onlyTrashed()->paginate(10);
        return view('marca.trashed', compact('marcas'));
    }
}
