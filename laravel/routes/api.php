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
    Route::get('movie', [MovieController::class, 'index']); // Mostrar todas las películas
    Route::post('movie', [MovieController::class, 'store']); // Crear una nueva película
    Route::get('movie/{id}', [MovieController::class, 'show']); //Mostrar una peli por id

    // Rutas para las sesiones de una película específica
        Route::get('session', [SessionController::class, 'index']); // Mostrar todas las sesiones de una película
        Route::post('session', [SessionController::class, 'store']); // Crear una nueva sesión para una película


    // Rutas para los asientos de una sesión específica
        Route::get('seient', [SeatController::class, 'index']); // Mostrar todos los asientos de una sesión
        Route::post('seient', [SeatController::class, 'store']); // Crear un nuevo asiento para una sesión
        Route::get('seient/{id}', [SeatController::class, 'show']);
        Route::post('/insert-seients',[SeatController::class, 'insert']);



?>
