<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    /**
     * Muestra todos los asientos de una sesión específica.
     *
     * @param  int  $sessionId
     * @return \Illuminate\Http\Response
     */
    public function index($sessionId)
    {
        try {
            $seats = Seat::where('session_id', $sessionId)->get();
            return response()->json(['success' => true, 'seats' => $seats], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al recuperar los asientos'], 500);
        }
    }

    /**
     * Crea un nuevo asiento para una sesión específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $sessionId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $sessionId)
    {
        $request->validate([
            'seat_num' => 'required|string|unique:seats',
            'es_reservat' => 'required|boolean',
        ]);

        try {
            $seat = new Seat();
            $seat->session_id = $sessionId;
            $seat->seat_num = $request->seat_num;
            $seat->es_reservat = $request->es_reservat;
            $seat->save();
            
            return response()->json(['success' => true, 'seat' => $seat], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear el asiento'], 500);
        }
    }
}
