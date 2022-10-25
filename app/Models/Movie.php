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
}
