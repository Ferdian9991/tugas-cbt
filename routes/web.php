<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\User;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route(auth()->user()->role === User::ROLE_ADMIN ? 'packages.index' : 'exam-front.index');
    } else {
        return redirect()->route('login');
    }
});

Auth::routes();

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::resource('packages', App\Http\Controllers\PackageController::class);
    Route::resource('packages/{id}/questions', App\Http\Controllers\PackageQuestionController::class);
    Route::resource('exams', App\Http\Controllers\ExamScheduleController::class);
    Route::resource('exams/{id}/participants', App\Http\Controllers\ExamParticipantController::class, [
        'names' => [
            'index' => 'exam_participants.index',
            'create' => 'exam_participants.create',
            'store' => 'exam_participants.store',
            'destroy' => 'exam_participants.destroy',
        ],
        'only' => ['index', 'store', 'destroy', 'create'],
    ]);
    Route::resource('participants', App\Http\Controllers\ParticipantController::class);
    Route::resource('admins', App\Http\Controllers\AdminController::class);

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changepassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::get('/hakakses', [App\Http\Controllers\HakaksesController::class, 'index'])->name('hakakses.index')->middleware('superadmin');
    Route::get('/hakakses/edit/{id}', [App\Http\Controllers\HakaksesController::class, 'edit'])->name('hakakses.edit')->middleware('superadmin');
    Route::put('/hakakses/update/{id}', [App\Http\Controllers\HakaksesController::class, 'update'])->name('hakakses.update')->middleware('superadmin');
    Route::delete('/hakakses/delete/{id}', [App\Http\Controllers\HakaksesController::class, 'destroy'])->name('hakakses.delete')->middleware('superadmin');
});

Route::middleware(['auth', 'peserta'])->group(function () {
    Route::resource('exam-front', App\Http\Controllers\ExamFrontController::class, [
        'only' => ['index', 'show', 'update'],
    ]);

    Route::post('/exam-front/{id}/answer', [App\Http\Controllers\ExamFrontController::class, 'updateParticipantAnswer'])
        ->name('exam-front.answer');

    Route::post('/exam-front/{id}/submit', [App\Http\Controllers\ExamFrontController::class, 'submitExam'])
        ->name('exam-front.submit');
});
