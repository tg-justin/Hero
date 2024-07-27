<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\QuestLogController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Manager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\ServeFileController;

Route::get('/', function()
{
	$cookies = Cookie::get();
	foreach ($cookies as $name => $value)
	{
		Cookie::queue(Cookie::forget($name));
	}
	return redirect()->route('welcome');
});

Route::get('/dashboard', function()
{
	return redirect()->route('quests.index');
})->name('dashboard');

Route::get('/welcome', function()
{
	return view('welcome');
})->name('welcome');

Route::get('/email-verified', function()
{
	return view('/email-verified');
})->name('email.verified');

require __DIR__ . '/auth.php';

Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::middleware('auth')->group(function()
{
	Route::get('/report', [ReportController::class, 'index'])->name('report.index');



	// this has to be behind auth, so the nav won't throw an error
	Route::get('/default-styles', function()
	{
		return view('default-styles');
	})->name('default.styles');

	// Serve quest files that have been uploaded by Managers
	// http://hero.test/storage/quests/2/sample.pdf
	Route::get('/storage/quests/{questId}/{filename}', [ServeFileController::class, 'serveQuestFile'])
		->where('questId', '[0-9]+')  // Ensure questId is a number
		->where('filename', '.*');  // Allow any filename

	// Serve quest files that have been uploaded by Heroes
	// http://hero.test/storage/feedback/2/14/another-file-20240705-190436.pdf
	Route::get('/storage/feedback/{questId}/{questLogId}/{filename}', [ServeFileController::class, 'serveQuestLogFile'])
		->where('questId', '[0-9]+')  // Ensure questId is a number
		->where('questLogId', '[0-9]+')  // Ensure questLogId is a number
		->where('filename', '.*');  // Allow any filename

	// All other routes with 'verified' middleware
	Route::middleware('verified')->group(function()
	{
		/*******************************************************************************************
		 * Hero Registration
		 *******************************************************************************************/

		Route::get('/hero-registration', [ProfileController::class, 'heroRegistration'])
			->name('profile.hero-registration');
		Route::post('/hero-registration', [ProfileController::class, 'submitHeroRegistration'])
			->name('profile.submit-hero-registration');

		/*******************************************************************************************
		 * Profile Management
		 *******************************************************************************************/

		Route::get('/profile', [ProfileController::class, 'showProfileOwn'])
			->name('profile.show-profile-own');
		Route::get('/profile/{heroId}', [ProfileController::class, 'showProfile'])
			->where('heroId', '[1-9][0-9]*')
			->name('profile.show-profile');

		Route::get('/profile/edit/public', [ProfileController::class, 'editPublicInfoOwn'])
			->name('profile.edit-public-info-own');
		Route::get('/profile/edit/public/{heroId}', [ProfileController::class, 'editPublicInfo'])
			->where('heroId', '[1-9][0-9]*')
			->name('profile.edit-public-info');
		Route::post('/profile/edit/public', [ProfileController::class, 'submitPublicInfo'])
			->name('profile.submit-public-info');

		Route::get('/profile/edit/personal', [ProfileController::class, 'editPersonalInfoOwn'])
			->name('profile.edit-personal-info-own');
		Route::get('/profile/edit/personal/{heroId}', [ProfileController::class, 'editPersonalInfo'])
			->where('heroId', '[1-9][0-9]*')
			->name('profile.edit-personal-info');
		Route::post('/profile/edit/personal', [ProfileController::class, 'submitPersonalInfo'])
			->name('profile.submit-personal-info');

		Route::get('/profile/edit/mailing', [ProfileController::class, 'editMailingAddressOwn'])
			->name('profile.edit-mailing-address-own');
		Route::get('/profile/edit/mailing/{heroId}', [ProfileController::class, 'editMailingAddress'])
			->where('heroId', '[1-9][0-9]*')
			->name('profile.edit-mailing-address');
		Route::post('/profile/edit/mailing', [ProfileController::class, 'submitMailingAddress'])
			->name('profile.submit-mailing-address');

		Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
		Route::get('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
		Route::get('/profile/change-email-address', [ProfileController::class, 'changeEmailAddress'])->name('profile.change-email-address');
		Route::post('/profile/change-email-address', [ProfileController::class, 'submitChangeEmailAddress'])->name('profile.submit-change-email-address');

		/*******************************************************************************************
		 * Quests and Quest Logs
		 *******************************************************************************************/

		Route::resource('quests', QuestController::class);
		Route::post('/quests/{quest}/accept', [QuestController::class, 'accept'])->name('quests.accept');
		Route::get('/quests/{quest}/duplicate', [QuestController::class, 'duplicate'])->name('quests.duplicate');
		Route::get('/quests/{quest}/confirm-delete', [QuestController::class, 'destroy'])->name('quests.confirm-delete');

		Route::get('/quest-log', [QuestLogController::class, 'index'])->name('quest-log.index');

		Route::get('/quest-log/{questLog}/complete', [QuestLogController::class, 'showCompleteForm'])->name('quest-log.complete-form');
		Route::post('/quest-log/{questLog}/complete', [QuestLogController::class, 'complete'])->name('quest-log.complete');

		Route::get('/quest-log/{questLog}/drop-confirm', [QuestLogController::class, 'confirmDrop'])->name('quest-log.drop-confirm');
		Route::post('/quest-log/{questLog}/drop', [QuestLogController::class, 'drop'])->name('quest-log.drop');

		/*******************************************************************************************
		 * Manager Routes
		 *******************************************************************************************/

		Route::middleware([Manager::class])->group(function()
		{
			Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
			Route::get('/manager/heroes', [HeroController::class, 'index'])->name('manager.heroes');
			Route::post('/manager/heroes/{hero}/promote', [HeroController::class, 'promote'])->name('heroes.promote');
			Route::get('/manager/heroes/{user}/quest-logs', [QuestLogController::class, 'indexForUser'])->name('manager.quest-logs');
			Route::post('/manager/heroes/{hero}/send-password-reset', [HeroController::class, 'sendPasswordResetEmail'])->name('manager.heroes.sendPasswordReset');

			Route::get('/manager/review', [ManagerDashboardController::class, 'review'])->name('manager.review');

			Route::get('/quest-logs/{questLog}/review', [QuestLogController::class, 'review'])->name('quest-logs.review');
			Route::get('/quest-logs/{questLog}/edit', [QuestLogController::class, 'edit'])->name('quest-logs.edit');
			Route::put('/quest-logs/{questLog}', [QuestLogController::class, 'update'])->name('quest-logs.update');

			Route::get('/quests/{quest}/quest-logs', [QuestLogController::class, 'indexForQuest'])->name('quests.quest-logs');
		});

		/*******************************************************************************************
		 * Manager Routes
		 *******************************************************************************************/

		Route::middleware([Admin::class])->group(function()
		{
			Route::resource('categories', CategoryController::class);
			Route::get('/admin/activity-log', [ActivityLogController::class, 'index'])->name('activitylog');
		});
	});
});