<?php

namespace AbuLoot\Epay;

use Illuminate\Support\ServiceProvider;

class EpayServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bind('epay', function($app) {
			return new Epay;
		});
	}

	public function boot()
	{
		// Loading the routes file
		require __DIR__.'/Http/routes.php';

		// Define the path for view file
		$this->loadViewsFrom(__DIR__.'/views', 'epay');
	}
}