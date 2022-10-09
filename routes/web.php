<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\ScheduleController;
/*
|-------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice' , [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
Route::get('/getPractice', [PracticeController::class, 'getPractice']);

// Route::prefix()

Route::prefix('/movies')->group(function (){
    Route::get('/', [MovieController::class, 'index']);
    Route::get('/{id}', [ScheduleController::class, 'index']);
});



Route::get('/sheets',[SheetController::class,'index']);

Route::prefix('/admin/movies')->group(function (){
    Route::get('/' , [AdminMovieController::class,'index']);
    Route::post('/search' , [AdminMovieController::class,'']);
    Route::get('/create'  , [AdminMovieController::class,'create']);
    Route::post('/store'  , [AdminMovieController::class,'store']);
    Route::get('/{id}/edit'      ,[AdminMovieController::class,'edit']);
    Route::patch('/{id}/update'  ,[AdminMovieController::class,'update']);
    Route::delete('/{id}/destroy',[AdminMovieController::class,'delete']);

    Route::get('/{id}',[AdminScheduleController::class,'index']);
    Route::get('/{id}/schedule/create',[AdminScheduleController::class,'create']);
    Route::get('/{id}/schedule/store',[AdminScheduleController::class,'store']);
    Route::get('/{id}/schedule/edit',[AdminScheduleController::class,'edit']);
    Route::get('/{id}/schedule/update',[AdminScheduleController::class,'update']);
    Route::get('/{id}/schedule/destroy',[AdminScheduleController::class,'destroy']);






    // 定義してないやつらの扱い
    Route::fallback(function () {
        return \App::abort(404);
    });
});
