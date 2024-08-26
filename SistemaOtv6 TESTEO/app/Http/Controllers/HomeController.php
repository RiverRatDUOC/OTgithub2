<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Método para mostrar la página de inicio
    public function index()
    {
        return view('home.home'); // Ahora busca en la carpeta 'home'
    }
}
