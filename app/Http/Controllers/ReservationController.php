<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Movie;
use App\Models\Sheet;

class ReservationController extends Controller
{
    public function index($movie_id,$schedule_id,Request $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date)) {abort(400);}

       return view('sheet.index', [
           "movie_id"       => $movie_id,
           "schedule_id"    => $schedule_id,
           "screening_date" => $request->screening_date,
           "sheets" => Sheet::all()
       ]);
    }

    public function create($movie_id,$schedule_id,Request $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date) || empty($request->sheetId)) {abort(400);}

        return view('movie.reservation', [
            "movie_id"       => $movie_id,
            "schedule_id"    => $schedule_id,
            "screening_date" => $request->screening_date,
            "sheet_id"        => $request->sheetId
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'     =>'required|max:255',
            'email'    =>'required|max:255|email',
            "schedule_id" =>'required',
            "screening_date" =>'required',
            "sheet_id" =>'required',
        ]);

        // すでに予約されてないか
        if (Reservation::isAllReadyExist($request)) {
            // return redirect("movies/{$request->movie_id}")->with([
            //     "message"        => "そこはすでに予約されています",
            //     "movie_id"       => $movie_id,
            //     "schedule_id"    => $schedule_id,
            //     "screening_date" => $request->screening_date,
            //     "sheets" => Sheet::all()
            // ]);
            return redirect("/movies/{$request->movie_id}/schedules/{$request->schedule_id}/sheets?screening_date={$request->screening_date}")->with([
                "message"        => "そこはすでに予約されています",
                "movie_id"       => $request->movie_id,
                "schedule_id"    => $request->schedule_id,
                "screening_date" => $request->screening_date,
                "sheets" => Sheet::all()
            ]);
        }

        Reservation::storeReservateion($request);

        return redirect("movies/{$request->movie_id}")->with([
            'message'   => "予約した",
        ]);
    }
}
