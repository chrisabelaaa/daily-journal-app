<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot password
Route::get('/forgot-password', function () {
    return view('auth.passwords.email');
})->middleware('guest')->name('password.request');
Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink(
        $request->only('email')
    );
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JournalController;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
    return view('dashboard');
});
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::match(['get', 'post', 'delete'], '/profile/photo', [ProfileController::class, 'photo'])->name('profile.photo');
    // Journals
    Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/journals/archived', [JournalController::class, 'archived'])->name('journals.archived');
    Route::get('/journals/{id}/edit', [JournalController::class, 'edit'])->name('journals.edit');
    Route::put('/journals/{id}', [JournalController::class, 'update'])->name('journals.update');
    Route::patch('/journals/{id}/archive', [JournalController::class, 'archive'])->name('journals.archive');
    Route::patch('/journals/{id}/restore', [JournalController::class, 'restore'])->name('journals.restore');
    Route::delete('/journals/{id}/force-delete', [JournalController::class, 'forceDelete'])->name('journals.force-delete');
    Route::resource('activities', App\Http\Controllers\ActivityController::class);
});
