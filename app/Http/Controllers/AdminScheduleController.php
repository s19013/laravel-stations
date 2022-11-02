<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;

use App\Repository\ScheduleRepository;

use App\Models\Movie;
use App\Models\Schedule;

class AdminScheduleController extends Controller
{
    public $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $id)
    {
        return view('admin.schedule.index', [
            'movie' => Movie::with('schedules')->find($id)
        ]);
    }

    public function redirectToIndex(int $movie_id,string $message = null)
    {
        return redirect("/admin/movies/${movie_id}")->with([
            'movie' => Movie::with('schedules')->find($movie_id),
            'message'   => $message,
        ]);
    }

    public function create(string $id) { return view('admin.schedule.create')->with(['movieId' => $id]); }

    public function store(ScheduleRequest $request)
    {
        // 登録
        $this->scheduleRepository->store($request);

        return $this->redirectToIndex($request->movie_id,"{$request->id}にスケジュールを追加しました");
    }

    public function edit(string $id) {
        return view('admin.schedule.edit')->with([
            'movieSchedule' => Schedule::find($id),
        ]);
    }

    public function update(ScheduleRequest $request)
    {
        $this->scheduleRepository->update($request);

        return $this->redirectToIndex($request->movie_id,"{$request->id}のスケジュールを変更しました");
    }

    public function destroy(String $id)
    {
        if ($this->scheduleRepository->isExists($id)) {
            $this->scheduleRepository->delete($id);

            return redirect("/admin/movies/");
        }
        return \App::abort(404);
    }

}
