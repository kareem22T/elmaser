<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\RegisterController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Admin\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'getIndex'])->name('site.home');

Route::get('/register', [RegisterController::class, 'getRegisterIndex']);
Route::middleware('auth:sanctum')->get('/get-user', [RegisterController::class, 'getUser'])->name('site.get-user');
Route::post('/register', [RegisterController::class, 'register'])->name('site.register');
Route::get('/article/{id}', [HomeController::class, 'getArticleIndex']);
Route::get('/search', [ArticleController::class, 'searchIndex']);
Route::get('/tag/{name}/{id}', [ArticleController::class, 'tagIndex']);
Route::get('/category/{id}', [ArticleController::class, 'categoryIndex']);

Route::get('/about-us', function() {
    return view("site.about");
});
Route::get('/privacy', function() {
    return view("site.privacy");
});
Route::get('/about-ads', function() {
    return view("site.ads");
});
Route::get('/contact-us', function() {
    return view("site.contact");
});
