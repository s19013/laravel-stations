<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Movie;



class AdminMovieController extends Controller
{
    public function index()
    {
        $movieList =Movie::all();
        return view('admin.movie.index', ['movieList' => $movieList]);
    }

    public function store(Request $request)
    {

        // タイトルにかぶりがないかチェック
        if (Movie::isAllreadyExists($request->title)) {
            return redirect(route('movie.create'),302)->with(
                ['allReadyExists' => 'そのタイトルはすでに登録されています']
            )->withInput();
        }

        // 登録
        Movie::storeMovie(
            title         :$request->title,
            image_url     :$request->image_url,
            description   :$request->description,
            is_showing    :$request->is_showing,
            published_year:$request->published_year
        );

        $movieList = Movie::all();
        return redirect('/admin/movies')->with([
            'movieList' => $movieList,
            'message'   => '映画を追加しました',
        ]);
    }

    public function transitionToCreate()
    {
        return view('admin.movie.create');
    }


}
