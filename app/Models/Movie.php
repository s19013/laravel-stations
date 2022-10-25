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

    //hasMany設定
    // リレーションシップ設定
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

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
        $request->is_showing = (boolean)$request->is_showing;

        $searchToolKit = new searchToolKit();

        // %と_をエスケープ
        $escaped = $searchToolKit->sqlEscape($request->keyword);

        //and検索のために空白区切りでつくった配列を用意
        $wordListToSearch = $searchToolKit->preparationToAndSearch($escaped);

        // 基本クエリ
        $query = Movie::select('*');

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
        if ($request->is_showing === true) { $query->where('is_showing','=',1); }
        //  == だとnullも0扱いになるので ===
        if ($request->is_showing === false) { $query->where('is_showing','=',0); }

        // 取得
        return $query->get();
    }

    // 単体データ取得
    public static function getSingleMovieData($id)
    {
        // 1つだけとってくるからfirstで十分
        return Movie::select('*')->where('id','=',$id)->first();
    }

    public static function isExists($id)
    {
        return Movie::where('id','=',$id)->exists();
    }


}
