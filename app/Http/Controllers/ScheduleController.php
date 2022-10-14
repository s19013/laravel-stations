<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Movie;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index($id)
    {
        return view('movie.schedule', [
            'movie' => Movie::with('schedules')->find($id)
        ]);
    }
}
