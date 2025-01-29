<?php

use App\Http\Controllers\Api\EpisodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// route /api/user
Route::get('/user', function (Request $request) {
    dd('ok');
});
Route::get('episode/{id}',[EpisodeController::class,'episode'])->name('episode');