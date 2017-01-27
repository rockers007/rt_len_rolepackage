<?php

namespace Module\ROLES;

use Illuminate\Support\ServiceProvider;

class ROLEServiceProvider extends ServiceProvider
{
	public function boot(){
		include __DIR__ . '/routes.php';
		//$this->loadviewsFrom(__DIR__ . '/view','bmi');
	}
	public function register(){
		$this->app['roles'] = $this->app->share(function ($app) {
			return new ROLES;
		});
	}
} 