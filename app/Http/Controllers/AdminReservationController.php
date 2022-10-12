<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Movie;
use App\Models\Sheet;
use Carbon\CarbonImmutable;

class AdminReservationController extends Controller
{
    public function index()
    {
        // "reservationList" => Reservation::getAllReservation(CarbonImmutable::now())
        return view('admin.reservation.index', [
            "reservationList" => Reservation::with('sheet')->where("reservations.screening_date",">=",CarbonImmutable::now())->get()
        ]);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }
}
