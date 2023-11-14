<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PosAccountController;
use App\Http\Controllers\ContentController;

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

Route::group(['middleware'=>'api'],function($router){
    Route::post('/register',[RegistrationController::class,'register']);
    Route::get('/verify',[RegistrationController::class,'verifyEmail']);
    Route::post('/loginCheck',[RegistrationController::class,'login'])->name('logincheck');

    // content route
    Route::get('view/individual/content/{id}',[ContentController::class,'individualData'])->name('view.individual.content');

});

//Route::post('/pos/request',[PosAccountController::class,'store']);

