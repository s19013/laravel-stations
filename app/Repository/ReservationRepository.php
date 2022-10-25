<?php

namespace App\Repository;

use App\Models\Reservation;

class ReservationRepository
{
    public  function storeReservation($request)
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

    public  function updateReservation($reservation_id,$request)
    {
        \DB::transaction(function () use($reservation_id,$request){
            Reservation::where('id','=',$reservation_id)
            ->update([
                "screening_date" => $request->screening_date,
                "schedule_id"    => $request->schedule_id,
                "sheet_id" => $request->sheet_id,
                "user_id"  => $request->user_id,
            ]);
        });
    }

    public  function deleteReservation($reservation_id)
    {
        \DB::transaction(function () use($reservation_id){
            Reservation::where('id','=',$reservation_id)
            ->delete();
        });
    }

    public  function isDeleted($reservation_id)
    {
        return !(Reservation::where('id','=',$reservation_id)->exists());
    }

    public  function isAllReadyExist($sheet_id,$schedule_id)
    {
        return Reservation::where("schedule_id","=",$schedule_id)
        ->where("sheet_id","=",$sheet_id)
        ->exists();
    }

    public  function isAllreadyReserved($schedule_id)
    {
        $returnValueList = Reservation::select("sheet_id")->where("schedule_id","=",$schedule_id)->get();

        $reservedSheetList =[] ;

        foreach($returnValueList as $returnValue){ array_push($reservedSheetList,$returnValue->sheet_id); }

        return $reservedSheetList;
    }

    public  function getIdOfMovieReservated($reservation_id)
    {
        return Reservation::select('movies.id as movie_id')
        ->join("schedules","schedules.id","=",'reservations.schedule_id')
        ->join("movies","movies.id","=","schedules.movie_id")
        ->first();
    }

    public  function getAllReservation($date)
    {
        return Reservation::join("sheets","sheets.id","=","reservations.sheet_id")
        ->where("reservations.screening_date",">=",$date)
        ->get();
    }
}

