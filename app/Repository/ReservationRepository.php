<?php

namespace App\Repository;

use App\Models\Reservation;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\AdminReservationRequest;

class ReservationRepository
{
    public  function store(ReservationRequest $request)
    {
        \DB::transaction(function () use($request){
            Reservation::create([
                "screening_date" => $request->screening_date,
                "schedule_id"    => $request->schedule_id,
                "sheet_id" => $request->sheet_id,
                "user_id"  => $request->user_id,
            ]);
        });
    }

    public  function adminStore(AdminReservationRequest $request)
    {
        \DB::transaction(function () use($request){
            Reservation::create([
                "screening_date" => $request->screening_date,
                "schedule_id"    => $request->schedule_id,
                "sheet_id" => $request->sheet_id,
                "user_id"  => $request->user_id,
            ]);
        });
    }

    public  function update(AdminReservationRequest $request)
    {
        \DB::transaction(function () use($request){
            Reservation::where('id','=',$request->reservation_id)
            ->update([
                "screening_date" => $request->screening_date,
                "schedule_id"    => $request->schedule_id,
                "sheet_id" => $request->sheet_id,
                "user_id"  => $request->user_id,
            ]);
        });
    }

    public  function delete(string $reservation_id)
    {
        \DB::transaction(function () use($reservation_id){
            Reservation::where('id','=',$reservation_id)
            ->delete();
        });
    }

    public  function isDeleted(String $reservation_id)
    {
        return !(Reservation::where('id','=',$reservation_id)->exists());
    }

    public  function isAllReadyExist($sheet_id,$schedule_id)
    {
        return Reservation::where("schedule_id","=",$schedule_id)
        ->where("sheet_id","=",$sheet_id)
        ->exists();
    }

    public  function isAllreadyReserved(String $schedule_id)
    {
        $returnValueList = Reservation::select("sheet_id")->where("schedule_id","=",$schedule_id)->get();

        $reservedSheetList =[] ;

        foreach($returnValueList as $returnValue){ array_push($reservedSheetList,$returnValue->sheet_id); }

        return $reservedSheetList;
    }

    public  function getIdOfMovieReservated(String $reservation_id)
    {
        return Reservation::select('movies.id as movie_id')
        ->join("schedules","schedules.id","=",'reservations.schedule_id')
        ->join("movies","movies.id","=","schedules.movie_id")
        ->first();
    }

    public  function getAllReservation(String $date)
    {
        return Reservation::join("sheets","sheets.id","=","reservations.sheet_id")
        ->where("reservations.screening_date",">=",$date)
        ->get();
    }
}

