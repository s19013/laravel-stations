<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

use App\Models\Movie;
use App\tool\searchToolKit;
use DB;

class MovieRepository
{
    // 登録
    public function store($request)
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

    public function update($request)
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

    public function search($request)
    {
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
        if ($request->is_showing === "1") { $query->where('is_showing','=',1); }
        //  == だとnullも0扱いになるので ===
        if ($request->is_showing === "0") { $query->where('is_showing','=',0); }

        // 取得
        return $query->get();
    }

    public static function isExists($id)
    {
        return Movie::where('id','=',$id)->exists();
    }


}
