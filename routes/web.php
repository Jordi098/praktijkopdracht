<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\EnsureUserIsAdmin;

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


Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/story/{story}/approve', [AdminController::class, 'approve'])->name('admin.story.approve');
    Route::post('/admin/story/{story}/reject', [AdminController::class, 'reject'])->name('admin.story.reject');
    Route::post('/admin/story/{story}/deactivate', [AdminController::class, 'deactivate'])->name('admin.story.deactivate');
    Route::post('/admin/story/{id}/restore', [AdminController::class, 'restore'])->name('admin.story.restore');
    Route::post('/admin/story/{id}/force-delete', [AdminController::class, 'forceDelete'])->name('admin.story.forceDelete');

});
Route::middleware('auth')->group(function () {
    Route::get('story/edit/{story}', [StoryController::class, 'edit'])->name('story.edit');
    Route::get('story/create', [StoryController::class, 'create'])->name('story.create');
    Route::post('story/store', [StoryController::class, 'store'])->name('story.store');
    Route::get('Mystories', [StoryController::class, 'myStories'])->name('story.myStories');
    Route::put('story/update/{story}', [StoryController::class, 'update'])->name('story.update');
    Route::delete('story/destroy/{story}', [StoryController::class, 'destroy'])->name('story.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
