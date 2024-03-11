<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return response()->json($movies);
    }

    public function store(Request $request)
    {
        $movie = new Movie();
        $movie->title = $request->input('titol');
        $movie->director = $request->input('director');
        $movie->year = $request->input('any');
        $movie->description = $request->input('descripcio');
        $movie->save();

        return response()->json($movie, 201);
    }
}
