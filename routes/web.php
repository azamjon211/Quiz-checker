<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\SubmissionController as AdminSubmissionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [QuizController::class, 'index'])->name('home');
Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{quiz}/submit', [SubmissionController::class, 'store'])->name('quiz.submit');
Route::get('/result/{submission}', [SubmissionController::class, 'show'])->name('result.show');

// Admin auth
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post')->middleware('throttle:admin-login');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin protected
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('quizzes', AdminQuizController::class)->except(['show']);
    Route::get('submissions', [AdminSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('submissions/{submission}', [AdminSubmissionController::class, 'show'])->name('submissions.show');

    // Superadmin only
    Route::middleware('superadmin')->group(function () {
        Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::post('users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    });
});
