<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;

use Illuminate\Validation\Rule;
use App\Models\Movie;



class AdminMovieController extends Controller
{
    public function index()
    {
        // 外部結合してないからこの書き方でも n+1は起きないはず
        $movieList =Movie::all();
        return view('admin.movie.index', ['movieList' => $movieList]);
    }

    public function redirectToIndex($message = null)
    {
        $movieList = Movie::all();
        return redirect('/admin/movies/')->with([
            'movieList' => $movieList,
            'message'   => $message,
        ]);
    }

    public function store(Request $request)
    {
        // チェックボックスにチェックがついてなかった時の処理
        // if (empty($request->is_showing)) { $request['is_showing'] = 0; }

        $request->validate([
            'title'       => 'required|unique:movies|max:220',
            'image_url'   => 'required|url',
            'description' => 'required',
            'is_showing'  => 'required',
            'published_year' => 'required',
        ]);

        // 登録
        Movie::storeMovie($request);

        return $this->redirectToIndex('映画を追加しました');
    }

    public function update(Request $request)
    {
        // if (empty($request->is_showing)) { $request['is_showing'] = 0; }

        // 自分以外に同じタイトルがないか
        $request->validate([
            'title'       => ['required', 'max:220', Rule::unique('movies')->ignore($request->id)],
            'image_url'   => 'required|url',
            'description' => 'required',
            'is_showing'  => 'required',
            'published_year' => 'required',
        ]);

        Movie::updateMovie($request);

        return $this->redirectToIndex('更新しました');
    }

    public function transitionToCreate() { return view('admin.movie.create'); }

    public function transitionToEdit($id) { return view('admin.movie.edit')->with(['movie' => Movie::getMovieData($id)]); }


}
