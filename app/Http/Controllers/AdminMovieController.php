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

    public function create() { return view('admin.movie.create'); }

    public function store(MovieRequest $request)
    {
        // チェックボックスにチェックがついてなかった時の処理
        // if (empty($request->is_showing)) { $request['is_showing'] = 0; }

        // 登録
        Movie::storeMovie($request);

        return $this->redirectToIndex('映画を追加しました');
    }

    public function edit($id) { return view('admin.movie.edit')->with(['movie' => Movie::getSingleMovieData($id)]); }

    public function update(MovieRequest $request)
    {
        // if (empty($request->is_showing)) { $request['is_showing'] = 0; }

        Movie::updateMovie($request);

        return $this->redirectToIndex('更新しました');
    }

    public function delete($id)
    {
        if (Movie::isExists($id)) {
            Movie::deleteMovie($id);
            return $this->redirectToIndex("{$id}番を削除しました");
        }
        return \App::abort(404);
    }

}
