<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminMovieController;
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
Route::get('/movies', [MovieController::class, 'index']);

// 試しにコントローラーもまとめたけど多分あまり良い書き方ではないかもしれない｡本番ではいろんなコントローラーを使うかもしれないし｡
Route::controller(AdminMovieController::class)->prefix('/admin/movies')->group(function () {
    Route::get('/' , 'index');
    Route::post('/search' , '');
    Route::get('/create'  , 'transitionToCreate');
    Route::post('/store'  , 'store');
    Route::get('/{id}/edit'      ,'transitionToEdit');
    Route::patch('/{id}/update'  ,'update');
    Route::delete('/{id}/destroy','delete');

    // 定義してないやつらの扱い
    Route::fallback(function () {
        return \App::abort(404);
    });
});
