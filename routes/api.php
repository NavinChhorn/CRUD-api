<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\AuthorCollectionIterator;

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

// ============== route for register======================================


Route::middleware("auth:sanctum")->group(function(){
    // ================================ posts route ==========================================================
    Route::get('/posts',[PostController::class,'index']);
    Route::get('/getPostsFrom/{id}',[PostController::class,'getPostsFrom']);
    Route::post('/posts',[PostController::class,'store']);
    Route::get('/posts/{id}',[PostController::class,'show']);
    Route::put('/posts/{id}',[PostController::class,'update']);
    Route::delete('/posts/{id}',[PostController::class,'destroy']);


    // ========================= user route ====================================================================
    Route::get('/users',[UserController::class,'index']);
    Route::post('/users',[UserController::class,'store']);
    Route::get('/users/{id}',[UserController::class,'show']);
    Route::put('/users/{id}',[UserController::class,'update']);
    Route::delete('/users/{id}',[UserController::class,'destroy']);


    // ================ many to many relationship=========================
    Route::get('/userole',[UserRoleController::class,'getRoleUser']);

    // ========= route logout =========================
    Route::post("/logout",[AuthenticationController::class,'logout']);

});
Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/login',[AuthenticationController::class,'login']);