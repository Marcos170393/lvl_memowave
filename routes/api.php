<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\EnsureClientIsResourceOwner;
Route::middleware(EnsureClientIsResourceOwner::class)->group(function() {

    Route::prefix('users')->group(function(){
        Route::get('/',[UserController::class,'login']);
        Route::get('/{userid}/notes',[UserController::class,'getUserNotes']);
        Route::post('/',[UserController::class,'store']);
    });

    Route::get('/notes/',[NoteController::class,'findAll']);
});