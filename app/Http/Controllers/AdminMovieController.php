<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostMovieRequest;
use App\Http\Requests\PatchMovieRequest;

use App\Repository\MovieRepository;

use Illuminate\Validation\Rule;
use App\Models\Movie;

class AdminMovieController extends Controller
{
    public $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function index()
    {
        // 外部結合してないからこの書き方でも n+1は起きないはず
        return view('admin.movie.index', ['movieList' => Movie::all()]);
    }

    public function redirectToIndex($message = null)
    {
        return redirect('/admin/movies/')->with([
            'movieList' => Movie::all(),
            'message'   => $message,
        ]);
    }

    public function create() { return view('admin.movie.create'); }

    public function store(PostMovieRequest $request)
    {
        // 登録
        $this->movieRepository->store($request);

        return $this->redirectToIndex('映画を追加しました');
    }

    public function edit($id) { return view('admin.movie.edit')->with(['movie' => Movie::select('*')->where('id','=',$id)->first()]); }

    public function update(PatchMovieRequest $request)
    {
        $this->movieRepository->update($request);

        return $this->redirectToIndex('更新しました');
    }

    public function destroy($id)
    {
        if ($this->movieRepository->isExists($id)) {
            $this->movieRepository->delete($id);
            return $this->redirectToIndex("{$id}番を削除しました");
        }
        return \App::abort(404);
    }

}
