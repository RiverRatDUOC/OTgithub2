<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(); // Obtén usuarios paginados, ajusta el número según tus necesidades

        $users = User::with('roles')->paginate(); // Carga los usuarios con sus roles

        return view('usuarios.usuarios', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.crear', compact('roles'));
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->roles);

        return redirect()->route('usuarios.index')->with('info', 'Usuario creado con éxito');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('usuarios.editar', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->roles);

        return redirect()->route('usuarios.editar', $user)->with('info', 'Se asignaron los roles correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('usuarios.index')->with('info', 'Usuario eliminado con éxito');
    }
    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar usuarios por nombre, correo o roles
        $users = User::where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhereHas('roles', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate(10); // ajusta el número de resultados por página según tus necesidades

        return view('usuarios.usuarios', compact('users'));
    }
}
