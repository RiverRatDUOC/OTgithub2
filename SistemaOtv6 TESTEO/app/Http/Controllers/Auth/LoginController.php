<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


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
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe tener un formato válido.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);

        Log::info('User Credentials:', ['email' => $credentials['email']]);
        Log::info('Authentication Query:', ['query' => DB::getQueryLog()]);
        Log::info('User Credentials: ' . json_encode($credentials));
        Log::info('Authentication Result: ' . (Auth::check() ? 'Success' : 'Failure'));

        // Obtener las credenciales de la base de datos
        $databaseCredentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        Log::info('Database Credentials: ' . json_encode($databaseCredentials));


        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return Redirect::back()->withErrors([
            'email' => 'Credenciales inválidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
