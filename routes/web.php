<?php

use App\Http\Controllers\FormaterController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/formater',[FormaterController::class, 'formater'])->name('formater');
//Route::get('/testing',[FormaterController::class, 'testing'])->name('testing');


Route::get('/test',[TestController::class, 'test'])->name('test');
