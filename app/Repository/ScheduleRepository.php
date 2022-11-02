<?php
declare(strict_types=1);
namespace App\Repository;

use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;

use App\Models\Schedule;
use App\tool\searchToolKit;
use DB;

class ScheduleRepository
{
    // 登録
    public  function store(ScheduleRequest $request)
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

    public  function update(ScheduleRequest $request)
    {
        DB::transaction(function () use($request){
            Schedule::where('id','=',$request->id)
            ->update([
                'screen_id'  => $request->screen_id,
                'start_time' => $request->start_time_date." ".$request->start_time_time,
                'end_time'   => $request->end_time_date." ".$request->end_time_time,
            ]);
        });
    }

    public  function delete(string $id)
    {
        DB::transaction(function () use($id){
            Schedule::where('id', '=',$id)->delete();
        });
    }

    public  function isExists(string $id)
    {
        return Schedule::where('id','=',$id)->exists();
    }
}
