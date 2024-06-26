<?php

namespace App\Providers;

use App\Models\QuestLog;
use App\Observers\QuestLogObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\View\Components\DateUserTimeZone;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		// Register QuestLog observer
		QuestLog::observe(QuestLogObserver::class);

		// Register custom Blade components
		Blade::component('date-user-time-zone', DateUserTimeZone::class);
	}
}