<?php

namespace Webudvikleren\CrudEvents\Providers;

use Illuminate\Support\ServiceProvider;

class CrudEventsProvider extends ServiceProvider
{
	/**
	 * Bootstrap services.
	 * 
	 * @return void
	 */
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
		$this->loadTranslationsFrom(__DIR__ . '/../lang', 'crudevents');
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'crudevents');
		$this->mergeConfigFrom(
			__DIR__.'/../config/crudevents.php', 'crudevents'
		);

		$this->publishes([
			__DIR__ . '/../public' => public_path(''),
		], 'crudevents-assets');
	}
}