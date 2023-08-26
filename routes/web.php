<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home');
    }
    return view('welcome');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/searchView', [App\Http\Controllers\HomeController::class, 'searchView'])->name('searchView');
Route::get('/fetchAllWorkouts', [App\Http\Controllers\HomeController::class, 'fetchAllWorkouts'])->name('fetchAllWorkouts');

Route::get('/users/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::post('/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::post('/users/complete_profile', [App\Http\Controllers\UserController::class, 'complete_profile'])->name('users.complete_profile');
Route::get('/users/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('users.profile');
Route::post('/users/follow/{id}', [App\Http\Controllers\UserController::class, 'follow'])->name('users.follow');
Route::post('/users/unfollow/{id}', [App\Http\Controllers\UserController::class, 'unfollow'])->name('users.unfollow');
Route::get('/users/followModal/{id}', [App\Http\Controllers\UserController::class, 'followModal'])->name('users.followModal');


Route::post('/workouts/store', [App\Http\Controllers\WorkoutController::class, 'store'])->name('workouts.store');
Route::get('/workouts/fetchAll', [App\Http\Controllers\WorkoutController::class, 'fetchAll'])->name('workouts.fetchAll');
Route::delete('/workouts/delete', [App\Http\Controllers\WorkoutController::class, 'delete'])->name('workouts.delete');

Route::post('/comments/store/{workout_id}', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
