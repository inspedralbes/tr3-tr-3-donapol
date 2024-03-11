<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index(){
         return view('movies.index');
    }

    public function show($id){
        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => '9f657d8a',
            'i' => $id
        ]);

        $movie = $response->json();
        return view('movies.show', compact('movie'));
    }

    public function search(Request $request)
    {
        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => '9f657d8a',
            's' => $request->query('query')
        ]);

        $movies = $response->json()['Search'];

        return view('movies.search', compact('movies'));
    }

    public function getPoster($id)
    {
        $response = Http::get('http://img.omdbapi.com/', [
            'apikey' => '9f657d8a',
            'i' => $id
        ]);

        return redirect($response->header('Location'));
    }
}
