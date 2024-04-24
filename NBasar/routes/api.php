<?php

use App\Http\Controllers\Estate\EstateController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route; 



Route::group([], function(){
    Route::post('/estate/images', [ImageController::class,'saveImages']);
    Route::delete('/estate/images/{uuid}', [ImageController::class,'deleteImages']);
});

Route::group([], function(){
    Route::patch('/user/{id}',[ UserController::class,'patchUser']);
    Route::delete('/user/{id}',[ UserController::class,'deleteUser']);
    Route::post('/user/report/{id}',[ UserController::class,'reportEstate']);
    Route::post('/user/favorite/{id}',[ UserController::class,'addToFavorite']);
    Route::post('/user/contact/{id}',[ UserController::class,'contactSeller']);
});
Route::group([],function(){
    Route::post('/user',[ UserController::class,'createUser']);
    Route::post('/user/login',[ UserController::class,'login']);
    
    Route::get('/user/favorites/{id}', [UserController::class,'getFavorites']);
    Route::get('/user/owned/{id}', [UserController::class,'getOwned']);
    Route::get('/users/{limit}',[ UserController::class,'all']);
    Route::post('/user/favorite',[ UserController::class,'addToFavorite']);
    Route::post('/user/contact',[ UserController::class,'addToFavorite']);
});
Route::group([],function(){
    Route::get('/user', [UserController::class,'getUser']);
    Route::patch('/user',[ UserController::class,'patchUser']);
})->middleware(['auth:sanctum']);


//'middleware' => 'EstateMiddleware',
Route::group(['namespace'=> 'Estate'], function(){
    Route::delete('/admin/estate/{uuid}', [EstateController::class,'deleteEstate']);
    Route::post('/estate', [EstateController::class,'createEstate']);
    Route::get('/estate/{uuid}', [EstateController::class,'getEstate']);
    Route::get('/estate/patch/{uuid}', [EstateController::class,'getpatchEstate']);

    Route::delete('/estate/{uuid}', [EstateController::class,'deleteEstate']);
    Route::patch('/estate/{uuid}', [EstateController::class,'patchEstate']);
});
Route::get('/a', function(){
    return 'a';
});


?>