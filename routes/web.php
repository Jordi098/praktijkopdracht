<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\HomeController;

Route::get('/', [StoryController::class, 'index'])->name('home');

//Route::get('/', [StoryController::class, 'index'])
//    ->name('home');
//Route::get('/story/{story}', [StoryController::class, 'findStory'])
//    ->name('story');
//
//Route::get('/story/create', [StoryController::class, 'create'])
//    ->name('create');
//
//Route::get('/story/store', [StoryController::class, 'store'])
//    ->name('store');
Route::resource('story', StoryController::class);


Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/about', function () {
    return view('about-us');
})->name('about');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
