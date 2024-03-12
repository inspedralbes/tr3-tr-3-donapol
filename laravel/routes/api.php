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
Route::prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index']); // Mostrar todas las películas
    Route::post('/', [MovieController::class, 'store']); // Crear una nueva película
    Route::get('/{id}', [MovieController::class, 'show']); //Mostrar una peli por id

    // Rutas para las sesiones de una película específica
    Route::prefix('/{movie}/sessions')->group(function () {
        Route::get('/', [SessionController::class, 'index']); // Mostrar todas las sesiones de una película
        Route::post('/', [SessionController::class, 'store']); // Crear una nueva sesión para una película
    });

    // Rutas para los asientos de una sesión específica
    Route::prefix('/sessions/{session}/seats')->group(function () {
        Route::get('/', [SeatController::class, 'index']); // Mostrar todos los asientos de una sesión
        Route::post('/', [SeatController::class, 'store']); // Crear un nuevo asiento para una sesión
    });
    Route::post('/sessions/{sessionId}/reserve', [ReservationController::class, 'reserveSeats']); //reservar un asiento
});

?>
