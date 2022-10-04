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
    public static function storeMovie($title,$image_url,$description,$is_showing,$published_year)
    {
        if (empty($is_showing)) {$is_showing = false;}
        DB::transaction(function () use($title,$image_url,$description,$is_showing,$published_year){
            Movie::create([
                'title'     => $title,
                'image_url' => $image_url,
                'description' => $description,
                'is_showing'  => $is_showing,
                'published_year' => $published_year,
            ]);
        });
    }
}
