<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    // hasMany
    // 自分のテーブルのカラムを参照しているテーブル(モデル)を設定
    public function Reservations()
    {
       return $this->hasMany('App\Models\Reservation');
    }

    public static function getRow($row)
    {
        return Sheet::where('row','=',$row)->get();
    }
}
