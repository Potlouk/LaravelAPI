<?php

use App\Http\Controllers\Estate\EstateController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route; 


Route::group([], function(){
    Route::patch('/user/{id}',[ UserController::class,'patchUser']);
    Route::delete('/user/{id}',[ UserController::class,'deleteUser']);
    Route::post('/user/report/{id}',[ UserController::class,'reportEstate']);
    Route::post('/user/favorite/{id}',[ UserController::class,'addToFavorite']);
    Route::post('/user/contact/{id}',[ UserController::class,'contactSeller']);
});
Route::group([], function(){
    Route::post('/user',[ UserController::class,'createUser']);
    Route::get('/user/{id}', [UserController::class,'getUser']);
    
    Route::get('/users/{limit}',[ UserController::class,'all']);
});
//'middleware' => 'EstateMiddleware',
Route::group(['namespace'=> 'Estate'], function(){
    Route::delete('/admin/estate/{uuid}', [EstateController::class,'deleteEstate']);
    Route::post('/estate', [EstateController::class,'createEstate']);
    Route::delete('/estate/{uuid}', [EstateController::class,'getEstate']);
    Route::patch('/estate/{uuid}', [EstateController::class,'patchEstate']);
    Route::get('/estate/{uuid}', [EstateController::class,'getEstate']);
});
Route::get('/a', function(){
    return 'a';
});


?>