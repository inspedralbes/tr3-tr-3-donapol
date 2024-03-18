<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Ticket;

    class TicketController extends Controller
    {
        public function store(Request $request)
        {
            // Valida y guarda los datos del ticket en la base de datos
            $ticket = new Ticket();
            $ticket->movie_id = $request->input('movie_id');
            $ticket->seat_id = $request->input('seat_id');
            $ticket->preu = $request->input('preu');
            $ticket->email = $request->input('email');
            $ticket->save();

            // Retorna una respuesta JSON indicando que el ticket se ha guardado correctamente
            return response()->json(['message' => 'Ticket creado correctamente'], 201);
        }
    }