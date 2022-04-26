<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\FavoriteController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');
Route::get('/recipes/new', [RecipeController::class, 'create'])->name('recipe.create');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipe.store');
Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipe.show');
Route::middleware(['auth'])->group(function() {

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/homepage', [HomepageController::class, 'index'])->name('homepage.index');
    Route::get('/homepage/favorite', [HomepageController::class, 'favorite'])->name('homepage.favorite');
    Route::post('/comment/{id}', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/favorite/{id}', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::post('/favorite/delete/{id}', [FavoriteController::class, 'delete'])->name('favorite.delete');
    Route::get('/recipes/edit/{id}', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::post('/recipes/edit/{id}', [RecipeController::class, 'update'])->name('recipe.update');
    Route::post('/recipes/delete/{id}', [RecipeController::class, 'delete'])->name('recipe.delete'); 
    Route::post('/comment/edit/{id}', [CommentController::class, 'update'])->name('comment.update'); 
    Route::post('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');   
});

Route::get('/register', [RegisterController::class, 'index'])->name('registration.index');
Route::post('/register', [RegisterController::class, 'register'])->name('registration.create');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}