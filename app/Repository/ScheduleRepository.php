<?php

namespace App\Repository;

use App\Models\Schedule;
use App\tool\searchToolKit;
use DB;

class ScheduleRepository
{
    // 登録
    public  function store($request)
    {
        DB::transaction(function () use($request){
            Schedule::create([
                'movie_id'   => $request->movie_id,
                'screen_id'  => $request->screen_id,
                'start_time' => $request->start_time_date." ".$request->start_time_time,
                'end_time'   => $request->end_time_date." ".$request->end_time_time,
            ]);
        });
    }

    public  function update($id,$request)
    {
        DB::transaction(function () use($id,$request){
            Schedule::where('id','=',$id)
            ->update([
                'screen_id'  => $request->screen_id,
                'start_time' => $request->start_time_date." ".$request->start_time_time,
                'end_time'   => $request->end_time_date." ".$request->end_time_time,
            ]);
        });
    }

    public  function delete($id)
    {
        DB::transaction(function () use($id){
            Schedule::where('id', '=',$id)->delete();
        });
    }

    public  function isExists($id)
    {
        return Schedule::where('id','=',$id)->exists();
    }
}
