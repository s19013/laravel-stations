<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\tool\searchToolKit;

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

    public static function deleteMovie($id)
    {
        DB::transaction(function () use($id){
            Movie::where('id', '=',$id)->delete();
        });
    }

    public static function search($request)
    {
        $searchToolKit = new searchToolKit();

        // %と_をエスケープ
        $escaped = $searchToolKit->sqlEscape($articleToSearch);

        //and検索のために空白区切りでつくった配列を用意
        $wordListToSearch = $searchToolKit->preparationToAndSearch($escaped);


        // 基本クエリ
        $query = Movie::select('*');

        // キーワード追加
        foreach($wordListToSearch as $word){
            $query->where('title','like',$word);
            $query->where('description','like',$word);
        }

        // 検索対象
        if ($request->target == "showing") { $query->where('is_showing','=',1); }
        if ($request->target == "not showing") { $query->where('is_showing','=',0); }

        // 取得
        return $query->get();
    }

    // 単体データ取得
    public static function getMovieData($id)
    {
        // 1つだけとってくるからfirstで十分
        return Movie::select('*')->where('id','=',$id)->first();
    }

    public static function isExists($id)
    {
        return Movie::where('id','=',$id)->exists();
    }


}
