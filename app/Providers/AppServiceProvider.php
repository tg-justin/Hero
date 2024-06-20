<?php

namespace App\Providers;

use App\Models\QuestLog;
use App\Observers\QuestLogObserver;
use Illuminate\Support\ServiceProvider;

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
		QuestLog::observe(QuestLogObserver::class);
	}
}
