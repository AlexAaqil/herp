<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Users\ProfileController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\TeacherController;
use App\Http\Controllers\Classrooms\ClassroomCategoryController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\MessageController;

Route::view('/', 'index')->name('home-page');
Route::view('/about', 'about')->name('about-page');
Route::view('/services', 'services')->name('services-page');
Route::view('/contact', 'contact')->name('contact-page');
Route::post('/contact', [MessageController::class, 'store'])->name('messages.store');

Route::middleware(['auth', 'verified', 'active'])->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['admin'])->group(function() {
        Route::resource('users', UserController::class)->except('show');
        Route::resource('teachers', TeacherController::class)->only('index', 'edit');

        Route::resource('classroom-categories', ClassroomCategoryController::class)->only('store', 'edit', 'update', 'destroy');
        Route::resource('classrooms', ClassroomController::class)->except('show');

        Route::resource('dorms', DormController::class)->except('show');

        Route::resource('messages', MessageController::class)->only('index', 'edit', 'destroy');
    });
});

require __DIR__.'/auth.php';
