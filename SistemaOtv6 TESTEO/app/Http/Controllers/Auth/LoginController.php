<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\Usuario;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar los campos de inicio de sesión
        $credentials = $request->validate([
            'email' => 'required|email', // Requiere que el campo de email no esté vacío y sea un email válido
            'password' => 'required', // Requiere que la contraseña no esté vacía
        ], [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico es inválido.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        // Obtener el usuario por correo electrónico
        $user = Usuario::where('email_usuario', $credentials['email'])->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if ($user && password_verify($request->input('password'), $user->password_usuario)) {
            Auth::login($user);
            return redirect()->intended('/home'); // Redirigir al home
        }

        // Si las credenciales son incorrectas, regresar al login con un mensaje de error
        return Redirect::back()->withErrors([
            'email' => 'Credenciales inválidas.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
