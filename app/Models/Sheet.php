<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    public static function getRow($row)
    {
        return Sheet::where('row','=',$row)->get();
    }
}
