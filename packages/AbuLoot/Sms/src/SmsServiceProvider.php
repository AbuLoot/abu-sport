<?php

namespace AbuLoot\Sms;

use AbuLoot\Sms\MobizonApi;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
	public function boot()
	{
        $this->publishes([__DIR__ . '/config/sms.php' => config_path('sms.php')]);

		// $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        // $loader->alias('Mobizone', 'AbuLoot\Sms\Facades\Mobizon');

		require __DIR__ . '/Http/routes.php';
	}

	public function register()
	{
		$this->mergeConfigFrom(__DIR__ . '/config/sms.php', 'sms');

		// $this->app->bind('mobizon', function() {
            // return new MobizonApi(config('sms.key'));
		// });
	}
}