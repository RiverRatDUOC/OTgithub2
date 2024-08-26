<?php

namespace App\Http\Controllers\ControladorRoles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(); // Carga los roles con sus permisos y los pagina

        return view('roles.roles', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.crear', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('info', 'Rol creado con éxito');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.editar', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.index')->with('info', 'Permisos del rol asignados correctamente');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('info', 'Rol eliminado con éxito');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        $roles = Role::where('name', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->paginate(10); // Ajusta el número de resultados por página según tus necesidades

        return view('roles.roles', compact('roles'));
    }
}
