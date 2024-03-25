<?php

use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SingleController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/single/{post}', [SingleController::class,'index'])->name('single');
Route::post('/single/{post}/comment', [SingleController::class,'comment'])
    ->middleware('auth:web')
    ->name('single.comment');


Route::prefix('admin')->middleware('admin')->group(function (){
    Route::resource('post',PostController::class)->except(['show']);
});

