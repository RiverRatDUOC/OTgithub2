<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario; // Cambiado a Usuario
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Carga los usuarios con sus roles, utilizando 'nombre_usuario' en lugar de 'name'
        $users = Usuario::with('roles')->paginate();

        return view('usuarios.usuarios', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('usuarios.crear', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validar la entrada del formulario
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email_usuario' => 'required|string|email|max:255|unique:usuario',
            'password_usuario' => 'required|string|min:8|confirmed',
            'roles' => 'array'
        ]);

        // Crear el usuario y dejar 'rol_usuario' como nulo
        $user = Usuario::create([
            'nombre_usuario' => $request->nombre_usuario,
            'email_usuario' => $request->email_usuario,
            'password_usuario' => bcrypt($request->password_usuario),
            'rol_usuario' => null, // Dejar el rol como nulo
        ]);

        // Asigna los roles si se han proporcionado
        if ($request->roles) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('usuarios.index')->with('info', 'Usuario creado con éxito');
    }


    public function edit(Usuario $user) // Cambiado a Usuario
    {
        $roles = Role::all();
        return view('usuarios.editar', compact('user', 'roles'));
    }

    public function update(Request $request, Usuario $user)
    {
        // Validar la entrada del formulario
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email_usuario' => 'required|string|email|max:255|unique:usuario,email_usuario,' . $user->id, // Excluir el usuario actual de la validación única
            'password_usuario' => 'nullable|string|confirmed', // Validación para la contraseña opcional
            'roles' => 'array', // Validar que roles sea un arreglo
        ]);

        // Actualiza el usuario
        $user->update([
            'nombre_usuario' => $request->nombre_usuario,
            'email_usuario' => $request->email_usuario,
            // Actualiza la contraseña solo si se proporciona una nueva, si no, mantiene la actual
            'password_usuario' => $request->password_usuario ? bcrypt($request->password_usuario) : $user->password_usuario,
        ]);

        // Asigna los roles solo si se proporcionan
        if ($request->roles) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('usuarios.editar', $user)->with('info', 'Usuario actualizado correctamente');
    }


    public function destroy(Usuario $user) // Cambiado a Usuario
    {
        $user->delete();

        return redirect()->route('usuarios.index')->with('info', 'Usuario eliminado con éxito');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search');

        // Filtrar usuarios por nombre, correo o roles
        $users = Usuario::where('nombre_usuario', 'like', "%$search%") // Cambiado a nombre_usuario
            ->orWhere('email_usuario', 'like', "%$search%") // Cambiado a email_usuario
            ->orWhereHas('roles', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate(10); // ajusta el número de resultados por página según tus necesidades

        return view('usuarios.usuarios', compact('users'));
    }
}
