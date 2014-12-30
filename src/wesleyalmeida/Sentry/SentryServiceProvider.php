<?php namespace Wesleyalmeida\Sentry;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class SentryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('wesleyalmeida/sentry');

		//include __DIR__ . '/../../config/sentry.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['sentry'] = $this->app->share(function($app)
		{
			return new Sentry;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
