<?php namespace Wesleyalmeida\Sentry;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;

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

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		App::bind('sentry', function($app, $user_roles) {

			return new Sentry($user_roles);
		});

		/*$this->app['sentry'] = $this->app->share(function($app)
		{
			return new Sentry;
		});*/
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
