<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\EnsureClientIsResourceOwner;
Route::middleware(EnsureClientIsResourceOwner::class)->group(function() {

    Route::get('/users',[UserController::class,'login']);
    Route::post('/users',[UserController::class,'store']);

    Route::get('/notes',[NoteController::class,'findAll']);
});