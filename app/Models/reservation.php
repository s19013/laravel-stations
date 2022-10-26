<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    //belongsTo設定
    // 参照したいカラムがあるテーブル(モデル)を設定
    public function sheet()
    {
       return $this->belongsTo('App\Models\Sheet');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}

