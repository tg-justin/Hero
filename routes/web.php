<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\QuestLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Manager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ManagerDashboardController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/auth.php';

Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');



Route::middleware('auth')->group(function () {
    // this has to be behind auth, so the nav won't throw an error
    Route::get('/default-styles', function () {
        return view('default-styles');
    })->name('default.styles');

    // Profile routes without 'verified' middleware
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/hero-registration', [ProfileController::class, 'updateHeroRegistration'])->name('profile.update-hero-registration');

        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // All other routes with 'verified' middleware
    Route::middleware('verified')->group(function () {
        Route::get('/hero-registration', [ProfileController::class, 'heroRegistration'])->name('profile.hero-registration');
        Route::post('/hero-registration', [ProfileController::class, 'submitHeroRegistration'])->name('profile.register-hero');
        Route::resource('quests', QuestController::class);
        Route::post('/quests/{quest}/accept', [QuestController::class, 'accept'])->name('quests.accept');

        Route::get('/quest-log', [QuestLogController::class, 'index'])->name('quest-log.index');
        Route::get('/quest-log/{questLog}/complete', [QuestLogController::class, 'showCompleteForm'])->name('quest-log.complete-form');
        Route::post('/quest-log/{questLog}/complete', [QuestLogController::class, 'complete'])->name('quest-log.complete');

        Route::middleware([Manager::class])->group(function () {
            Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
            Route::get('/manager/heroes', [HeroController::class, 'index'])->name('manager.heroes');
            Route::post('/manager/heroes/{hero}/promote', [HeroController::class, 'promote'])->name('heroes.promote');
            Route::get('/manager/heroes/{user}/quest-logs', [QuestLogController::class, 'indexForUser'])->name('manager.quest-logs');
            Route::post('/manager/heroes/{hero}/send-password-reset', [HeroController::class, 'sendPasswordResetEmail'])->name('manager.heroes.sendPasswordReset');

            Route::get('/manager/review', [ManagerDashboardController::class, 'review'])->name('manager.review');

            Route::get('/quest-logs/{questLog}/review', [QuestLogController::class, 'review'])->name('quest-logs.review');
            Route::get('/quest-logs/{questLog}/edit', [QuestLogController::class, 'edit'])->name('quest-logs.edit');
            Route::put('/quest-logs/{questLog}', [QuestLogController::class, 'update'])->name('quest-logs.update');


        });

        Route::middleware([Admin::class])->group(function () {
            Route::resource('categories', CategoryController::class);
            Route::get('/admin/activity-log', [ActivityLogController::class, 'index'])->name('activitylog');
        });
    });
});
