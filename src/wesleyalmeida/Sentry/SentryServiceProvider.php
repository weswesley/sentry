<?php namespace Wesleyalmeida\Sentry;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

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
	public function register() {

		App::bindShared('sentry', function($app) {

			$defaults = Config::get('sentry::config.defaults');

			$sentry = new Sentry;
			$sentry->setDefaults($defaults);

			return $sentry;

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
