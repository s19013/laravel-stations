<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Models\Movie;
use App\Models\Sheet;
use Carbon\CarbonImmutable;

use App\Models\User;


class AdminReservationController extends Controller
{
    public function index()
    {
        return view('admin.reservation.index', [
            // こういうwith使ったやつも関数化してモデルファイルにおいて置くべきなのだろうか?
            "reservationList" => Reservation::with('sheet')->with('user')
            ->where("reservations.screening_date",">=",date('Y-m-d-', strtotime(CarbonImmutable::now())))->get()
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.reservation.create');
    }

    public function store(ReservationRequest $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date)) {abort(400);}
        if (empty($request->sheet_id)) {abort(400);}
        if (empty($request->movie_id)) {abort(400);}
        if (empty($request->schedule_id)) {abort(400);}
        if (empty($request->user_id)) {abort(400);}

        // すでに予約されてないか
        if (Reservation::isAllReadyExist($request->sheet_id,$request->schdule_id)) {
            return redirect("/admin/reservations")->with([
                "message"        => "そこはすでに予約されています",
            ]);
        }

        Reservation::storeReservation($request);

        return redirect("/admin/reservations")->with([
            'message'   => "予約した",
        ]);
    }

    public function edit($reservation_id)
    {
        return view('admin.reservation.edit',[
            "reservation" => Reservation::find($reservation_id),
            "movie_id"    => Reservation::getIdOfMovieReservated($reservation_id)
        ]);
    }

    public function update($reservation_id,ReservationRequest $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date)) {abort(400);}
        if (empty($request->sheet_id)) {abort(400);}
        if (empty($request->movie_id)) {abort(400);}
        if (empty($request->schedule_id)) {abort(400);}
        if (empty($request->user_id)) {abort(400);}

        Reservation::updateReservation($reservation_id,$request);

        return redirect("/admin/reservations")->with([
            'message'   => "更新した",
        ]);
    }

    public function destroy($reservation_id)
    {
        // 存在していなかったら400
        if (Reservation::isDeleted($reservation_id)) {abort(404);}

        Reservation::deleteReservation($reservation_id);

        return redirect("/admin/reservations")->with([
            'message'   => "削除した",
        ]);
    }

}

