<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CasosPruebasController;
use App\Http\Controllers\PdfController;

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

/* RUTAS BOTONES ACEPTACION/OBSERVACION */

Route::get('/observaCP/{idCP}', function ($idCP){

    CasosPruebas::where('id',$idCP)
        ->update([
            'aprobador' => 'observacion'
        ]);

    return redirect('/home');
})
    ->name('observaCP');

Route::get('/apruebaCP/{idCP}', function ($idCP){

    CasosPruebas::where('id',$idCP)
        ->update([
            'aprobador' => 'conforme'
        ]);

    return redirect('/home');
})
    ->name('apruebaCP');