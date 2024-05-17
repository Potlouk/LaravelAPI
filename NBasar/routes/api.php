<?php

use App\Http\Controllers\Estate\EstateController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route; 

Route::group(['namespace' => 'User', 'middleware' => ['auth:sanctum','UserMiddleware']],function(){
    Route::get('/user', [UserController::class,'getUser']);
    Route::get('/users',[UserController::class,'all']);
    Route::patch('/user',[UserController::class,'patchUser']);
    Route::delete('/user/{id}',[UserController::class,'deleteUser']);
    Route::get('/user/favorites/{id}', [UserController::class,'getFavorites']);
    Route::get('/user/owned/{id}', [UserController::class,'getOwned']);
    Route::post('/user/favorite',[UserController::class,'addToFavorite']);
    Route::post('/user/report',[UserController::class,'reportEstate']);
});


Route::group(['namespace' => 'Image', 'middleware' => ['auth:sanctum','ImageMiddleware']], function () {
    Route::delete('/estate/images/{uuid}', [ImageController::class, 'deleteImages']);
    Route::post('/estate/images', [ImageController::class, 'saveImages']);
});

Route::group(['namespace'=> 'Estate'], function(){
    Route::get('/estates/search', [EstateController::class,'searchEstate']);
    Route::get('/estate/{uuid}', [EstateController::class,'getEstate']);
    Route::get('/count', [EstateController::class,'getCount']);
    Route::get('/estates/search/count', [EstateController::class,'getEstateCount']);
    Route::get('/estates/reported', [EstateController::class,'getEstateReported']);
});

Route::group(['namespace' => 'Estate', 'middleware' => 'auth:sanctum'], function(){
    Route::post('/estate', [EstateController::class,'createEstate']);
    Route::get('/estate/patch/{uuid}', [EstateController::class,'getpatchEstate']);
    Route::patch('/estate/{uuid}', [EstateController::class,'patchEstate']);
    Route::delete('/estate/{uuid}', [EstateController::class,'deleteEstate']);
});

Route::group(['namespace'=> 'User'], function(){
    Route::post('/user/login',[UserController::class,'login']);
    Route::post('/user',[UserController::class,'createUser']);
});



?>