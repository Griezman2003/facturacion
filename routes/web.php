<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\principalController;
use App\Http\Controllers\facturaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UbicacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// rutas seguras

Route::middleware(['auth:admin'])->group(function () {
    Route::get('web/admin/dashboard', [AdminController::class, 'admin'])->name('admin');
    Route::get('web/admin/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('web/admin/facturas', [AdminController::class, 'facturas'])->name('facturas');
    Route::post('web/delete/usuario/{id}', [AdminController::class, 'delete'])->name('delete.usuario');
    Route::post('web/usuario/facturama/{id}', [AdminController::class, 'facturama'])->name('usuario.facturama');
    Route::get('/notificacion/{notificationId}/marcar-leida', [AdminController::class, 'marcarNotificacionComoLeida'])->name('notificaciones.leer');
    
});

Route::get('web/reporte', [ReporteController::class, 'reporte'])->name('enviarReporte');

Route::get('web/esperar/{user}', [UserController::class, 'esperar'])->name('esperando');
Route::get('web/estado/{user}', [UserController::class, 'verificarCuenta'])->name('estadoCuenta');

Route::middleware(['desktop.only'])->group(function () {
    Route::get('/', [PrincipalController::class, 'principal'])->name('home');
});
Route::get('web/login', [UserController::class, 'login'])->name('user.login');
Route::post('logout', [UserController::class, 'salir'])->name('user.logout');
Route::get('web/registro', [UserController::class, 'register'])->name('user.registro');
Route::post('register', [UserController::class, 'registro'])->name('user.register');
Route::post('login', [UserController::class, 'iniciarSesion'])->name('user.authenticate');
Route::get('eliminar/user/{id}', [UserController::class, 'eliminarUsuario'])->name('user.eliminar');
// Route::get('web/profile', [UserController::class, 'show'])->name('profile.show');
// Route::post('web/profile/guardar', [UserController::class,'guardar'])->name('profile.guardar');


//Seccion estudiantes
Route::get('facturas', [FacturaController::class, 'index'])->name('facturas.index');
Route::get('facturas/recibo', [FacturaController::class, 'recibo'])->name('facturas.recibo');
Route::post('facturas/generate', [FacturaController::class, 'facturar'])->name('facturas.generate');



//Seccion Empresarial
Route::middleware(['auth:web'])->group(function () {
    Route::get('web/dashboard/{user}', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('web/factura/{user}', [DashboardController::class, 'showFacturaEmpresa'])->name('dashboard.factura');
    Route::post('dashboard/factura/generate/{user}', [DashboardController::class, 'generarFactura'])->name('dashboard.factura.generate');
    Route::post('cancelar-factura/{user}', [DashboardController::class, 'cancelarFactura'])->name('factura.cancelar');
    
    Route::get('web/serie/{user}', [DashboardController::class, 'serie'])->name('serie');
    Route::post('web/serie/sucursal/{user}', [DashboardController::class, 'serieSucursal'])->name('serie.sucursal');
    Route::post('web/serie/delete/{user}', [DashboardController::class, 'serieDelete'])->name('serie.delete');
    
    // sucursales empresa
    Route::get('web/sucursal/{user}', [DashboardController::class, 'sucursalUsuario'])->name('sucursal.usuario');
    Route::post('web/sucursal/{user}', [DashboardController::class, 'sucursal'])->name('sucursal');
    Route::post('web/eliminar/sucursal/{id}/{user}', [DashboardController::class, 'deleteSucursal'])->name('sucursal.delete');
    // fin
    
    Route::get('web/csd/{user}', [DashboardController::class, 'csd'])->name('csd');
    Route::post('web/csd/create/{user}', [DashboardController::class, 'create'])->name('csd.create');
    Route::post('web/csd/eliminar/{rfc}/{user}', [DashboardController::class, 'eliminar'])->where(['rfc' => '[A-Za-z0-9]+', 'user' => '[0-9]+'])->name('csd.eliminar');
    
});



Route::get('web/empresas/create', [EmpresaController::class, 'crear'])->name('empresas.create');
Route::post('empresas/store', [EmpresaController::class, 'empresa'])->name('empresas.store');

Route::get('/json/obtener-folio', [FacturaController::class, 'obtenerFolio']);
Route::post('/json/incrementar-folio', [FacturaController::class, 'incrementarFolio']);

Route::get('eliminar', [UserController::class, 'destroy'])->name('profile.eliminar');




// Seccion restablecer contraseñas
Route::post('web/resetpassword', [UserController::class, 'sendResetCode'])->name('password.email');
Route::post('verify-code', [UserController::class, 'verifyResetCode'])->name('password.verify.code');
Route::post('reset-password', [UserController::class, 'resetPassword'])->name('password.update');
Route::get('web/reset-password', [UserController::class, 'showResetPasswordForm'])->name('password.reset.view');

Route::get('/get-estados', [UbicacionController::class, 'getEstados']);
Route::get('/get-municipios/{estado_id}', [UbicacionController::class, 'getMunicipios']);
Route::get('/get-colonias/{estado_id}/{municipio_id}', [UbicacionController::class, 'getColonias']);

Route::get('nosotros', [UserController::class, 'nosotros'])->name('nosotros');

Route::get('/json/ClaveProdServ', function () {
    $path = storage_path('../json/ClaveProdServ.json');
    if (!File::exists($path)) {
        abort(404);
    }
    
    $file = File::get($path);
    $type = File::mimeType($path);
    
    return response($file, 200)->header("Content-Type", $type);
});
