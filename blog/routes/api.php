<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

Route::get('/clear-cache', function () {
    Cache::flush();
    Cache::clear();
    return 'DONE'; //Return anything
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    //? USER
    $router->post('/register', [AuthController::class, 'register']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/user', [AuthController::class, 'index']);
});




//? GENRE
$router->get('/genres', [GenreController::class, 'index']);
$router->get('/genres/{id}', [GenreController::class, 'show']);
$router->post('/genres-add', [GenreController::class, 'store']);
$router->put('/genres-edit/{id}', [GenreController::class, 'update']);
$router->delete('/genres-delete/{id}', [GenreController::class, 'destroy']);




//? MOVIE
$router->get('/movies', [MovieController::class, 'index']);
$router->get('/movies/{id}', [MovieController::class, 'show']);
$router->post('/movies-add', [MovieController::class, 'store']);
$router->put('/movies-edit/{id}', [MovieController::class, 'update']);
$router->delete('/movies-delete/{id}', [MovieController::class, 'destroy']);
$router->post('/movies-addFavorite/{movieId}', [MovieController::class, 'addFavorite']);
