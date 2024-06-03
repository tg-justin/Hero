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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	Route::resource('quests', QuestController::class);

    Route::get('/quest-log', [QuestLogController::class, 'index'])->name('quest-log.index');

    Route::post('/quests/{quest}/accept', [QuestController::class, 'accept'])->name('quests.accept');

    Route::get('/heroes', [HeroController::class, 'index'])->name('heroes.index');

   

	Route::middleware([Manager::class])->group(function () {
		Route::get('/users/{user}/quest-logs', [QuestLogController::class, 'indexForUser'])->name('users.quest-logs'); // Or use the policy here
		Route::get('/quest-logs/{questLog}/edit', [QuestLogController::class, 'edit'])->name('quest-logs.edit');
		Route::put('/quest-logs/{questLog}', [QuestLogController::class, 'update'])->name('quest-logs.update');
	});

});


