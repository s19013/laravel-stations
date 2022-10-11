<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($movie_id,$schedule_id,Request $request)
    {
        // クエリがないなら400
        if (empty($request->screening_date)) {
             return response()->json([
                "message" => "bad request",
                "status"  => 400
             ]);
        }

        return view('sheet.index', [
            "movie_id"       => $movie_id,
            "schedule_id"    => $schedule_id,
            "screening_date" => $request->screening_date,
            "sheets" => Sheet::all()
        ]);
    }
}
