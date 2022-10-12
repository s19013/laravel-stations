<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'start_time',
        'end_time'
    ];

    // リレーション
    //belongsTo設定
    // 参照したいカラムがあるテーブル(モデル)を設定
    public function Movies()
    {
       return $this->belongsTo('App\Models\Movie');
    }

    // hasMany
    // 自分のテーブルのカラムを参照しているテーブル(モデル)を設定
    public function Reservations()
    {
       return $this->hasMany('App\Models\Reservation');
    }


    public static function getScheduleData($id)
    {
        return Schedule::select('schedules.id','schedules.movie_id',"schedules.start_time","schedules.end_time")
        ->join('movies','schedules.movie_id','=','movies.id')
        ->where('schedules.movie_id','=',$id)
        ->get();
    }

    public static function getSingleScheduleData($id)
    {
        return Schedule::find($id);
    }


    // 登録
    public static function storeSchedule($request)
    {
        DB::transaction(function () use($request){
            Schedule::create([
                'movie_id'   => $request->movie_id,
                'start_time' => $request->start_time_date." ".$request->start_time_time,
                'end_time'   => $request->end_time_date." ".$request->end_time_time,
            ]);
        });
    }

    public static function updateSchedule($id,$request)
    {
        DB::transaction(function () use($id,$request){
            Schedule::where('id','=',$id)
            ->update([
                'start_time' => $request->start_time_date." ".$request->start_time_time,
                'end_time'   => $request->end_time_date." ".$request->end_time_time,
            ]);
        });
    }

    public static function deleteSchedule($id)
    {
        DB::transaction(function () use($id){
            Schedule::where('id', '=',$id)->delete();
        });
    }

    public static function isExists($id)
    {
        return Schedule::where('id','=',$id)->exists();
    }
}
