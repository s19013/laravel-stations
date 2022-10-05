<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // 登録
    public static function storeMovie($request)
    {
        if (empty($request->is_showing)) {$request->is_showing = false;}
        DB::transaction(function () use($request){
            Movie::create([
                'title'       => $request->title,
                'image_url'   => $request->image_url,
                'description' => $request->description,
                'is_showing'  => $request->is_showing,
                'published_year' => $request->published_year,
            ]);
        });
    }

    public static function updateMovie($request)
    {
        if (empty($request->is_showing)) {$request->is_showing = false;}
        DB::transaction(function () use($request){
            Movie::where('id','=',$request->id)
            ->update([
                'title'       => $request->title,
                'image_url'   => $request->image_url,
                'description' => $request->description,
                'is_showing'  => $request->is_showing,
                'published_year' => $request->published_year,
            ]);
        });
    }

    // 単体データ取得
    public static function getMovieData($id)
    {
        // 1つだけとってくるからfirstで十分
        return Movie::select('*')->where('id','=',$id)->first();
    }


}
