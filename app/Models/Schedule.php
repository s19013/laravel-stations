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
}
