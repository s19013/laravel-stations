<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    //belongsTo設定
    // 所属元を設定
    public function Reservations()
    {
       return $this->belongsTo('App\Models\Reservation');
    }

    public static function getRow($row)
    {
        return Sheet::where('row','=',$row)->get();
    }
}
