<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public static function getMovieSchedule($id)
    {
        return Schedule::select('schedules.start_time','schedules.end_time')
        ->join('movies','schedules.movie_id','=','movies.id')
        ->where('schedules.movie_id','=',$id)
        ->get();
    }
}
