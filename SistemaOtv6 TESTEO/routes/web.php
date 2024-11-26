<?php

use Illuminate\Support\Facades\Route;

// Importar los controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ControladorOrdenes\OrdenesController;
use App\Http\Controllers\ControladorRoles\RolesController;
use App\Http\Controllers\ControladorClientes\ClientesController;
use App\Http\Controllers\ControladorSucursales\SucursalesController;
use App\Http\Controllers\ControladorServicios\ServiciosController;
use App\Http\Controllers\ControladorServicios\TareaServiciosController;
use App\Http\Controllers\ControladorTecnicos\TecnicosController;
use App\Http\Controllers\ControladorEquipos\ModeloController;
use App\Http\Controllers\ControladorContactos\ContactosController;
use App\Http\Controllers\ControladorParametros\ParametrosController;
use App\Http\Controllers\ControladorDispositivo\DispositivoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController as UsuariosController;
use App\Http\Controllers\migrarController;
use App\Http\Controllers\PasswordUpdateController;
use App\Http\Controllers\ControladorOrdenes\AvancesController;
use App\Http\Controllers\ControladorParametros\CategoriaController;
use App\Http\Controllers\ControladorParametros\SubcategoriaController;
use App\Http\Controllers\ControladorParametros\LineaController;
use App\Http\Controllers\ControladorParametros\SublineaController;

// Ruta para actualizar contraseñas
Route::get('password-update', [PasswordUpdateController::class, 'index'])->name('password.update');

// Ruta para migrar datos
Route::get('migrar', [migrarController::class, 'index']);

// Ruta para procesar el envío del formulario de inicio de sesión
Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');

// Ruta para mostrar el formulario de inicio de sesión
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::middleware(['auth'])->group(function () {
    // Ruta para cerrar sesión
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Ruta para la página de inicio
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home.page');

    // RUTAS DE OT (Ordenes de Trabajo)
    Route::get('/ordenes/obtenerOrden/{id}', [OrdenesController::class, 'obtenerOrden']);
    Route::get('/ordenes', [OrdenesController::class, 'index'])->middleware('can:ordenes.index')->name('ordenes.index');
    Route::get('/ordenes/agregar', [OrdenesController::class, 'create'])->middleware('can:ordenes.create')->name('ordenes.create');
    Route::post('/ordenes/agregar', [OrdenesController::class, 'store'])->middleware('can:ordenes.create')->name('ordenes.store');
    Route::get('/ordenes/buscar', [OrdenesController::class, 'buscar'])->name('ordenes.buscar');
    Route::get('/ordenes/{orden}', [OrdenesController::class, 'show'])->name('ordenes.show');
    Route::get('/ordenes/{orden}/editar', [OrdenesController::class, 'edit'])->name('ordenes.edit');
    Route::post('/ordenes/{orden}/editar', [OrdenesController::class, 'update'])->name('ordenes.update');
    Route::get('/tareas/{servicioId}', [OrdenesController::class, 'tareas']);
    Route::get('/sucursal/{clienteId}', [OrdenesController::class, 'sucursales']);
    Route::get('/contacto/{sucursalId}', [OrdenesController::class, 'contactos']);
    Route::get('/dispositivo/{sucursalId}/{servicioId}', [OrdenesController::class, 'dispositivos']);
    Route::get('/servicio/{servicioId}', [OrdenesController::class, 'servicioTipo']);
    Route::get('/tecnicos/{servicioId}', [OrdenesController::class, 'tecnicosServicio']);

    // Rutas para TareaServiciosController
    Route::resource('tareas', TareaServiciosController::class);
    Route::get('tareas/buscar', [TareaServiciosController::class, 'buscar'])->name('tareas.buscar');

    // Rutas de Clientes
    Route::resource('clientes', ClientesController::class);
    Route::get('clientes/buscar', [ClientesController::class, 'buscar'])->name('clientes.buscar');

    // Rutas de Técnicos
    Route::resource('tecnicos', TecnicosController::class);
    Route::get('tecnicos/buscar', [TecnicosController::class, 'buscar'])->name('tecnicos.buscar');

    // Rutas de Avances (Ordenes - Avances)
    Route::get('/ordenes/{numero_ot}/avances', [AvancesController::class, 'index'])->name('ordenes.avances');
    Route::post('/ordenes/{numero_ot}/avances', [AvancesController::class, 'store'])->name('ordenes.avances.store');
    Route::post('/ordenes/{numero_ot}/finalizar', [AvancesController::class, 'finalizar'])->name('ordenes.finalizar');

    // Rutas de Sucursales
    Route::resource('sucursales', SucursalesController::class);
    Route::get('sucursales/buscar', [SucursalesController::class, 'buscar'])->name('sucursales.buscar');

    // Rutas de Servicios
    Route::resource('servicios', ServiciosController::class);
    Route::get('servicios/buscar', [ServiciosController::class, 'buscar'])->name('servicios.buscar');

    // Rutas de Contactos
    Route::resource('contactos', ContactosController::class);
    Route::get('contactos/buscar', [ContactosController::class, 'buscar'])->name('contactos.buscar');

    // Rutas de Modelos
    Route::resource('modelos', ModeloController::class);
    Route::get('modelos/buscar', [ModeloController::class, 'buscar'])->name('modelos.buscar');
    Route::get('modelos/{marca}/{sublinea}', [ModeloController::class, 'getModelos']);

    // Rutas de Usuarios
    Route::resource('usuarios', UsuariosController::class);
    Route::get('usuarios/buscar', [UsuariosController::class, 'buscar'])->name('usuarios.buscar');

    // Rutas de Parámetros
    Route::get('parametros', [ParametrosController::class, 'index'])->name('parametros.index');
    Route::get('parametros/{id}', [ParametrosController::class, 'show'])->name('parametros.show');

    // Rutas de Dispositivos
    Route::resource('dispositivos', DispositivoController::class);
    Route::get('dispositivos/buscar', [DispositivoController::class, 'buscar'])->name('dispositivos.buscar');

    // Rutas de Categorías
    Route::resource('categoria', CategoriaController::class);
    Route::get('categoria/trashed', [CategoriaController::class, 'trashed'])->name('categoria.trashed');
    Route::post('categoria/{id}/restore', [CategoriaController::class, 'restore'])->name('categoria.restore');
    Route::delete('categoria/{id}/force-delete', [CategoriaController::class, 'forceDelete'])->name('categoria.forceDelete');

    // Rutas de Subcategorías
    Route::resource('subcategoria', SubcategoriaController::class);

    // Rutas de Líneas
    Route::resource('lineas', LineaController::class);

    // Rutas de Sublíneas
    Route::resource('sublineas', SublineaController::class);

    // Rutas de Roles
    Route::resource('roles', RolesController::class);
    Route::get('roles/buscar', [RolesController::class, 'buscar'])->name('roles.buscar');
});
