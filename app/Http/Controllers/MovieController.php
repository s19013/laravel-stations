<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $movieList =Movie::search($request);
        return view('movie.index', ['movieList' => $movieList]);
    }
}
