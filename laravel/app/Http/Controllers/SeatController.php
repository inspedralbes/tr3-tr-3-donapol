<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;

class SeatController extends Controller
{
    //

    public function index()
    {
        return Seat::all();
    }

    public function insert(Request $request)
    {
        $seats = $request->json()->all();

       

        foreach ($seats as $seat) {
            Seat::create([
                'movie_id' => $seat['movie_id'],
                'status' => $seat['status'],
                'columna' => $seat['columna'], 
                'fila' => $seat['fila'],  
                'vip' => $seat['vip'],
            ]);
        }
        return response()->json(['message' => 'Seient afegit'], 201);
    }

    public function show($id)
    {
        return Seat::where('movie_id', $id)->get();
    }

    public function updateStatus($id)
    {
        $seat = Seat::find($id);

        if (!$seat) {
            return response()->json(['message' => 'El asiento no se encontró'], 404);
        }

        $seat->status = 'false';
        $seat->save();

        return response()->json(['message' => 'Estado del asiento actualizado correctamente'], 200);
    }

}