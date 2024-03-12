<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Seat;

class ReservationController extends Controller
{
    public function reserveSeats(Request $request, $sessionId)
    {
        // Obtener los asientos seleccionados de la solicitud
        $selectedSeats = $request->input('selectedSeats');

        // Iterar sobre los asientos seleccionados y marcarlos como reservados en la base de datos
        foreach ($selectedSeats as $seatName) {
            // Buscar el asiento por su nombre y el ID de la sesión
            $seat = Seat::where('session_id', $sessionId)
                        ->where('seat_num', $seatName)
                        ->first();

            // Marcar el asiento como reservado
            $seat->es_reservat = true;
            $seat->save();
        }

        // Devolver una respuesta JSON indicando que los asientos se reservaron correctamente
        return response()->json(['message' => 'Seients reservats correctament']);
    }
}

