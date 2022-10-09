<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;

use App\Models\Movie;
use App\Models\Schedule;

class AdminScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('admin.schedule.index', [
            'movieScheduleList' => Schedule::getScheduleData($id),
            'movieData'         => Movie::getSingleMovieData($id)
        ]);
    }

    public function redirectToIndex($message = null)
    {
        $movieList = Movie::all();
        return redirect('/admin/movies/')->with([
            'movieList' => $movieList,
            'message'   => $message,
        ]);
    }

    public function create($id) { return view('admin.schedule.create')->with(['movieId' => $id]); }

    public function store(ScheduleRequest $request)
    {
        // 登録
        Schedule::storeSchedule($request);

        return $this->redirectToIndex("{$request->id}にスケジュールを追加しました");
    }

    public function edit($id) {
        return view('admin.schedule.edit')->with([
            'movieSchedule' => Schedule::getSingleScheduleData($id),
            'scheduleId'=> $id
        ]);
    }

    public function update(ScheduleRequest $request)
    {
        Schedule::updateSchedule($request);

        return $this->redirectToIndex("{$request->id}のスケジュールを変更しました");
    }

    public function destroy($id)
    {
        if (Schedule::isExists($id)) {
            Schedule::deleteSchedule($id);
            return $this->redirectToIndex("{$id}のスケジュールを削除しました");
        }
        return \App::abort(404);
    }

}
