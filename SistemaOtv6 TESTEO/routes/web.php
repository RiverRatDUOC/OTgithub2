<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ControladorOrdenes\OrdenesController;
use App\Http\Controllers\ControladorRoles\RolesController;
use App\Http\Controllers\ControladorClientes\ClientesController;
use App\Http\Controllers\ControladorSucursales\SucursalesController;
use App\Http\Controllers\ControladorServicios\ServiciosController;
use App\Http\Controllers\ControladorServicios\TareaServiciosController;
use App\Http\Controllers\ControladorTecnicos\TecnicosController;
use App\Http\Controllers\ControladorEquipos\ModeloController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;


// Ruta para procesar el envío del formulario de inicio de sesión
Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');

// Ruta para mostrar el formulario de inicio de sesión
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::middleware(['auth'])->group(function () {

    // Ruta para cerrar sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Ruta para la página de inicio
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home.page');  // Ruta adicional para la página de inicio


    // RUTAS DE ORDENES
    Route::get('/ordenes', [OrdenesController::class, 'index'])->middleware('can:ordenes.index')->name('ordenes.index'); // Rutas para la carpeta 'ordenes'
    Route::get('/ordenes/agregar', [OrdenesController::class, 'create'])->middleware('can:ordenes.create')->name('ordenes.create'); // Ruta para crear una nueva orden
    Route::get('/ordenes/buscar', [OrdenesController::class, 'buscar'])->name('ordenes.buscar'); // Ruta para buscar órdenes
    Route::get('/ordenes/{orden}', [OrdenesController::class, 'show'])->name('ordenes.show'); // Ruta para mostrar el detalle de una orden


    // RUTAS DE CLIENTES
    Route::get('/clientes', [ClientesController::class, 'index'])->middleware('can:clientes.index')->name('clientes.index'); // Rutas para la carpeta 'clientes'
    Route::get('/clientes/agregar', [ClientesController::class, 'create'])->middleware('can:clientes.create')->name('clientes.create'); // Ruta para crear un nuevo cliente
    Route::get('/clientes/buscar', [ClientesController::class, 'buscar'])->name('clientes.buscar'); // Ruta para buscar órdenes

    // RUTAS DE TÉCNICOS
    Route::get('/tecnicos', [TecnicosController::class, 'index'])->name('tecnicos.index'); // Ruta para listar técnicos
    Route::get('/tecnicos/agregar', [TecnicosController::class, 'create'])->name('tecnicos.create'); // Ruta para crear un nuevo técnico
    Route::get('/tecnicos/buscar', [TecnicosController::class, 'buscar'])->name('tecnicos.buscar'); // Ruta para buscar técnicos


    // Rutas de Sucursales
    Route::get('/sucursales', [SucursalesController::class, 'index'])->name('sucursales.index'); // Ruta para listar sucursales
    Route::get('/sucursales/agregar', [SucursalesController::class, 'create'])->name('sucursales.create'); // Ruta para crear una nueva sucursal
    Route::get('/sucursales/buscar', [SucursalesController::class, 'buscar'])->name('sucursales.buscar'); // Ruta para buscar sucursales




    // Rutas de Servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index'); // Ruta para listar servicios
    Route::get('/servicios/agregar', [ServiciosController::class, 'create'])->name('servicios.create'); // Ruta para crear un nuevo servicio
    Route::get('/servicios/buscar', [ServiciosController::class, 'buscar'])->name('servicios.buscar'); // Ruta para buscar servicios



    // Rutas para el controlador TareaServiciosController
    Route::get('/tareas', [TareaServiciosController::class, 'index'])->name('tareas.index'); // Ruta para listar tareas
    Route::get('/tareas/agregar', [TareaServiciosController::class, 'create'])->name('tareas.create'); // Ruta para crear una nueva tarea
    Route::get('/tareas/buscar', [TareaServiciosController::class, 'buscar'])->name('tareas.buscar'); // Ruta para buscar tareas

    // Rutas para el controlador ModeloController
    Route::get('/modelos', [ModeloController::class, 'index'])->name('modelos.index'); // Ruta para listar modelos
    Route::get('/modelos/agregar', [ModeloController::class, 'create'])->name('modelos.create'); // Ruta para crear un nuevo modelo
    Route::get('/modelos/buscar', [ModeloController::class, 'buscar'])->name('modelos.buscar'); // Ruta para buscar modelos


    // Ruta para usuarios utilizando el controlador
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('usuarios.editar');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->middleware('can:usuarios.destroy')->name('usuarios.destroy');
    Route::get('/usuarios/buscar', [UserController::class, 'buscar'])->name('usuarios.buscar');


    // RUTAS DE ROLES


    Route::get('/roles', [RolesController::class, 'index'])->middleware('can:roles.index')->name('roles.index'); // Rutas para la carpeta 'roles'
    Route::get('/roles/create', [RolesController::class, 'create'])->middleware('can:roles.create')->name('roles.create');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->middleware('can:roles.edit')->name('roles.edit');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->middleware('can:roles.update')->name('roles.update');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->middleware('can:roles.destroy')->name('roles.destroy');
    Route::get('/roles/buscar', [RolesController::class, 'buscar'])->name('roles.buscar');
    Route::resource('roles', RolesController::class);
});
