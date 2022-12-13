<?php

use App\Http\Controllers\Api\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route::post('media-store',[MediaController::class,'store'])->name('media_store');
Route::get('media-store/{$id}',[MediaController::class,'show'])->name('media_show'); */

Route::apiResource('medias',MediaController::class);

Route::get('/media-list',[MediaController::class,'list']);
