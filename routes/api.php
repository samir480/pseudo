<?php

use App\Http\Controllers\WordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('word-list',[WordController::class,'getAllWords'])->name('word.list');
Route::get('word-detail/{id}',[WordController::class,'getWordDetail'])->name('word.detail');
Route::post('word-insert',[WordController::class,'create'])->name('word.create');
Route::delete('word-delete/{word_id}',[WordController::class,'delete'])->name('word.delete');
Route::patch('word-update/{word_id}',[WordController::class,'update'])->name('word.update');