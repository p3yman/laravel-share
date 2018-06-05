<?php
namespace Peyman3d\Share;

use Illuminate\Support\ServiceProvider;

class ShareServiceProvider extends ServiceProvider{
	
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register service
		$this->app->bind('share', '\Peyman3d\Share\Share');
	}
	
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Load helpers
		require_once('helpers.php');
	}

}