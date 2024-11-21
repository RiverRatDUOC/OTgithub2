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

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico es inválido.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        $user = Usuario::where('email_usuario', $credentials['email'])->first();

        if ($user && password_verify($request->input('password'), $user->password_usuario)) {
            Auth::login($user);
            return redirect()->intended('/home');
        }

        return Redirect::back()->withErrors([
            'email' => 'Credenciales inválidas.',
        ])->with('error_global');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
