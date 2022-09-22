<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Auth;

Route::get('/*', [ApplicationController::class, 'index']);


Route::get('{any}', function () {
    return view('welcome');
})->where('any', '.*');
