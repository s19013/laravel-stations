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

    public static function getScheduleData($id)
    {
        return Schedule::select('schedules.id','schedules.movie_id',"schedules.start_time","schedules.end_time")
        ->join('movies','schedules.movie_id','=','movies.id')
        ->where('schedules.movie_id','=',$id)
        ->get();
    }

    public static function getSingleScheduleData($id)
    {
        return Schedule::select('*')
        ->where('id','=',$id)
        ->first();
    }


    // 登録
    public static function storeSchedule($request)
    {
        DB::transaction(function () use($request){
            Schedule::create([
                'movie_id'   => $request->movie_id,
                'start_time' => $request->start_time_time,
                'end_time'   => $request->end_time_time,
            ]);
        });
    }

    public static function updateSchedule($request)
    {
        DB::transaction(function () use($request){
            Schedule::where('id','=',$request->id)
            ->update([
                'start_time' => $request->start_time_time,
                'end_time'   => $request->end_time_time,
            ]);
        });
    }

    public static function deleteSchedule($id)
    {
        DB::transaction(function () use($id){
            Schedule::where('id', '=',$id)->delete();
        });
    }

    public static function search($request)
    {
        $searchToolKit = new searchToolKit();

        // %と_をエスケープ
        $escaped = $searchToolKit->sqlEscape($request->keyword);

        //and検索のために空白区切りでつくった配列を用意
        $wordListToSearch = $searchToolKit->preparationToAndSearch($escaped);

        // 基本クエリ
        $query = Schedule::select('*');

        // キーワード追加
        foreach($wordListToSearch as $word){
            $query->where(function ($query) use ($word) {
                // タイトルか概要のどちらかなのでOr
                $query->where('title','like',"%$word%")
                ->orWhere('description','like',"%$word%");
            });
        }

        // () and 公開状態 という書き方のために上記

        // 検索対象
        // リクエストに送られるのはすべて""文字列""
        if ($request->is_showing === '1') { $query->where('is_showing','=',1); }
        //  == だとnullも0扱いになるので ===
        if ($request->is_showing === '0') { $query->where('is_showing','=',0); }

        // 取得
        return $query->get();
    }

    public static function isExists($id)
    {
        return Schedule::where('id','=',$id)->exists();
    }
}
