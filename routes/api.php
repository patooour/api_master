<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::group(['middleware' => ['api','checkPassword','changeLang']], function ()
{
    Route::post('/get-cats', [CategoryController::class, 'index']);
    Route::post('/get-cat-by-id', [CategoryController::class, 'CatId']);
    Route::post('/change-cat-status', [CategoryController::class, 'changeStatus']);

    Route::post('/Admin/login', [AuthController::class, 'getLogin']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.guard:admin-api');



        Route::post('/user/login', [\App\Http\Controllers\UserController::class, 'login']);



});

Route::group(['middleware' => ['api','checkPassword','changeLang' , 'CheckAdminToken:admin-api']], function ()
{
    Route::post('/get-cats', [CategoryController::class, 'index']);


});



Route::post('/cats', [CategoryController::class, 'cats']);


Route::group(['middleware' => ['auth.guard:user-api']], function ()
{
    Route::post('/profile', [CategoryController::class, 'profile']);


});
