<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ReservationController; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para las películas
    Route::post('movies', [App\Http\Controllers\MovieController::class, 'insert']); //Insertar nueva peli
    Route::get('movies', [App\Http\Controllers\MovieController::class, 'index']); //Mostrar todas las pelis
    Route::get('movies/{id}', [App\Http\Controllers\MovieController::class, 'show']); //Mostrar una peli por id
    Route::put('movies/{id}', [App\Http\Controllers\MovieController::class, 'update']); //Actualizar peli
    Route::delete('movies/{id}', [App\Http\Controllers\MovieController::class, 'destroy']); //Eliminar peli


// Rutas para los asientos de una sesión específica
    Route::get('seient', [SeatController::class, 'index']); // Mostrar todos los asientos de una sesión
    Route::post('seient', [SeatController::class, 'store']); // Crear un nuevo asiento para una sesión
    Route::get('seient/{id}', [SeatController::class, 'show']); //Mostrar un asiento
    Route::post('/insert-seients',[SeatController::class, 'insert']); //Insertar nuevo asiento

    Route::get('movies/{id}/seats', [SeatController::class, 'showSeatsForMovie']);




?>
