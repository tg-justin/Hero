<?php

use App\Http\Controllers\HeroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\QuestLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Manager;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/hero-registration', [ProfileController::class, 'heroRegistration'])->name('profile.hero-registration');
    Route::post('/hero-registration', [ProfileController::class, 'submitHeroRegistration'])->name('profile.register-hero');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::resource('quests', QuestController::class);
    Route::post('/quests/{quest}/accept', [QuestController::class, 'accept'])->name('quests.accept');

    Route::get('/quest-log', [QuestLogController::class, 'index'])->name('quest-log.index');
    Route::get('/quest-log/{questLog}/complete', [QuestLogController::class, 'showCompleteForm'])->name('quest-log.complete-form');
    Route::post('/quest-log/{questLog}/complete', [QuestLogController::class, 'complete'])->name('quest-log.complete');


    Route::middleware([Manager::class])->group(function () {
        Route::get('/heroes', [HeroController::class, 'index'])->name('heroes.index');
        Route::get('/users/{user}/quest-logs', [QuestLogController::class, 'indexForUser'])->name('users.quest-logs');
		Route::get('/quest-logs/{questLog}/edit', [QuestLogController::class, 'edit'])->name('quest-logs.edit');
		Route::put('/quest-logs/{questLog}', [QuestLogController::class, 'update'])->name('quest-logs.update');
	});

});


