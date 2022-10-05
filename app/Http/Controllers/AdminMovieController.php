<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;

use App\Models\Movie;



class AdminMovieController extends Controller
{
    public function index()
    {
        $movieList =Movie::all();
        return view('admin.movie.index', ['movieList' => $movieList]);
    }

    public function store(MovieRequest $request)
    {
        // 登録
        Movie::storeMovie($request);

        // 外部結合してないからこの書き方でも n+1は起きないはず
        $movieList = Movie::all();
        return redirect('/admin/movies/')->with([
            'movieList' => $movieList,
            'message'   => '映画を追加しました',
        ]);
    }

    public function update(MovieRequest $request)
    {
        Movie::updateMovie($request);

        $movieList = Movie::all();
        return redirect('/admin/movies/')->with([
            'movieList' => $movieList,
            'message'   => '更新しました',
        ]);
    }

    public function transitionToCreate()
    {
        return view('admin.movie.create');
    }

    public function transitionToEdit($id)
    {
        return view('admin.movie.edit')->with(['movie' => Movie::getMovieData($id)]);
    }


}
