<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;

use App\Models\Reservation;
use App\Models\Movie;
use App\Models\Sheet;

use App\Repository\ReservationRepository;

class ReservationController extends Controller
{
    public $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function index(Request $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date)) {abort(400);}

       return view('sheet.index', [
           "movie_id"       => $request->movie_id,
           "schedule_id"    => $request->schedule_id,
           "screening_date" => $request->screening_date,
           "sheets"   => Sheet::all(),
           "reserved" => $this->reservationRepository->isAllreadyReserved($request->schedule_id)
       ]);
    }

    public function create(ReservationRequest $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date) || empty($request->sheetId)) {abort(400);}

        // すでに予約されてないか
        if ($this->reservationRepository->isAllReadyExist($request)) {abort(400);}



        return view('movie.reservation', [
            "movie_id"       => $request->movie_id,
            "schedule_id"    => $request->schedule_id,
            "screening_date" => $request->screening_date,
            "sheet_id"       => $request->sheetId
        ]);
    }

    public function store(ReservationRequest $request)
    {
        // クエリがないなら400
        if (empty($request->sheet_id)) {abort(400);}
        if (empty($request->schedule_id)) {abort(400);}
        if (empty($request->screening_date)) {abort(400);}
        if (empty($request->user_id)) {abort(400);}

        // すでに予約されてないか
        if ($this->reservationRepository->isAllReadyExist($request)) {
            return redirect("/movies/{$request->movie_id}/schedules/{$request->schedule_id}/sheets?screening_date={$request->screening_date}")->with([
                "message"        => "そこはすでに予約されています",
                "movie_id"       => $request->movie_id,
                "schedule_id"    => $request->schedule_id,
                "screening_date" => $request->screening_date,
                "sheets" => Sheet::all()
            ]);
        }

        $this->reservationRepository->store($request);

        return redirect("movies/{$request->movie_id}")->with([
            'message'   => "予約した",
        ]);
    }
}
