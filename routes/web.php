<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CasosPruebasController;
use App\Http\Controllers\PdfController;
use App\Models\CasosPruebas;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* RUTA DE LOGIN */

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

/* RUTA DE IMPORTACION */

Route::get('/import', [CasosPruebasController::class, 'import'])->name('importar');

/* RUTA PDF */

Route::get('pdf/{id}', [PdfController::class, 'index'])->name('pdf');

/* RUTA VISTA CP */

Route::get('vistacp/{id}', [CasosPruebasController::class, 'index'])->name('vistacp');

/* RUTAS BOTONES ACEPTACION/OBSERVACION */

Route::get('/descartacp/{idCP}', function ($idCP){

    date_default_timezone_set('America/Lima');

    CasosPruebas::where('id',$idCP)
        ->update([
            'fecha_certificacion' => date('Y-m-d'),
            'resultado' => 'descartado'
        ]);

    return redirect('/dashboard');
})
    ->name('descartacp');

Route::get('/observacp/{idCP}', function ($idCP){

    CasosPruebas::where('id',$idCP)
        ->update([
            'fecha_certificacion' => date('Y-m-d'),
            'resultado' => 'observado'
        ]);

    return redirect('/dashboard');
})
    ->name('observacp');

Route::get('/apruebacp/{idCP}', function ($idCP){

    CasosPruebas::where('id',$idCP)
        ->update([
            'fecha_certificacion' => date('Y-m-d'),
            'resultado' => 'aprobado'
        ]);

    return redirect('/dashboard');
})
    ->name('apruebacp');


/* RUTA MERGE PDF */

Route::get('/reporte/{id}', [PdfController::class, 'mergePDF'])->name('reporte');