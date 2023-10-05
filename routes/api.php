<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/postsFollow', [HomeController::class, 'index']);

    Route::post('/logout', [AuthController::class, 'logout']); 

    //POST user
    Route::post('/posts/create', [PostController::class, 'store']); 
    
    Route::post('/images', [ImageController::class, 'store']); 

    Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store']); 
   
    Route::delete('/posts/{post}', [PostController::class, 'destroy']); 

    //get post likes
    Route::get('/posts/{post}/likes', [LikeController::class, 'index']); 
    Route::post('/posts/{post}/likes', [LikeController::class, 'store']); 
    Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy']); 

    Route::post('/{user:username}/edit-profile', [ProfilesController::class, 'editProfile']); 
   
    //Seguir Usuarios 
    Route::get('/{user:username}/follow', [FollowerController::class, 'index']);
    Route::post('/{user:username}/follow', [FollowerController::class, 'store']); 
    Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy']); 

  
    Route::get('/{user:username}/following', [FollowerController::class, 'following']);
});

//Show Post user 
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show']); 

//Get Comments from a Post
Route::get('/posts/{post}', [PostController::class, 'index']); 



//Get Profiles User URL 
Route::get('/{user:username}', [ProfilesController::class, 'index']); 

//Get following followers
Route::get('/{user:username}/followers', [FollowerController::class, 'followers']);


//Auth 
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login']); 