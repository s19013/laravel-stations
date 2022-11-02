<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminReservationRequest;

use App\Models\Reservation;
use App\Models\User;

use App\Repository\ReservationRepository;

use Carbon\CarbonImmutable;

class AdminReservationController extends Controller
{
    public $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function index()
    {
        return view('admin.reservation.index', [
            // こういうwith使ったやつも関数化してモデルファイルにおいて置くべきなのだろうか?
            "reservationList" => Reservation::with('sheet')->with('user')
            ->where("reservations.screening_date",">=",date('Y-m-d-', strtotime(CarbonImmutable::now())))->get()
        ]);
    }

    public function create()
    {
        return view('admin.reservation.create');
    }

    public function store(AdminReservationRequest $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date)) {abort(400);}
        if (empty($request->sheet_id)) {abort(400);}
        if (empty($request->movie_id)) {abort(400);}
        if (empty($request->schedule_id)) {abort(400);}
        if (empty($request->user_id)) {abort(400);}

        // すでに予約されてないか
        if ($this->reservationRepository->isAllReadyExist($request->sheet_id,$request->schdule_id)) {
            return redirect("/admin/reservations")->with([
                "message"        => "そこはすでに予約されています",
            ]);
        }

        $this->reservationRepository->adminStore($request);

        return redirect("/admin/reservations")->with([
            'message'   => "予約した",
        ]);
    }

    public function edit(String $reservation_id)
    {
        return view('admin.reservation.edit',[
            "reservation" => Reservation::find($reservation_id),
            "movie_id"    => $this->reservationRepository->getIdOfMovieReservated($reservation_id)
        ]);
    }

    public function update(AdminReservationRequest $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date)) {abort(400);}
        if (empty($request->sheet_id)) {abort(400);}
        if (empty($request->movie_id)) {abort(400);}
        if (empty($request->schedule_id)) {abort(400);}
        if (empty($request->user_id)) {abort(400);}

        $this->reservationRepository->update($request);

        return redirect("/admin/reservations")->with([
            'message'   => "更新した",
        ]);
    }

    public function destroy(String $reservation_id)
    {
        // 存在していなかったら400
        if ($this->reservationRepository->isDeleted($reservation_id)) {abort(404);}

        $this->reservationRepository->delete($reservation_id);

        return redirect("/admin/reservations")->with([
            'message'   => "削除した",
        ]);
    }

}

