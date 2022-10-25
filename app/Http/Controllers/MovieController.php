<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repository\MovieRepository;

use App\Models\Movie;

class MovieController extends Controller
{
    public $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function index(Request $request)
    {
        return view('movie.index', ['movieList' => $this->movieRepository->search($request)]);
    }
}
