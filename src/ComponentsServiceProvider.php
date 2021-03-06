<?php 
namespace Csgt\Components;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

class ComponentsServiceProvider extends ServiceProvider {

	protected $defer = false;

	public function boot(Router $router) {
		AliasLoader::getInstance()->alias('CSGTMenu','Csgt\Components\CSGTMenu');
		AliasLoader::getInstance()->alias('Components','Csgt\Components\Components');

		$this->mergeConfigFrom(__DIR__ . '/config/csgtcomponents.php', 'csgtcomponents');
    $this->loadViewsFrom(__DIR__ . '/resources/views/','csgtcomponents');

    if (!$this->app->routesAreCached()) {
      require __DIR__.'/Http/routes.php';
    }
    $router->aliasMiddleware('menu', '\Csgt\Components\Http\Middleware\MenuMW');
    $router->aliasMiddleware('god', '\Csgt\Components\Http\Middleware\GodMW');

		$this->publishes([
      __DIR__.'/config/csgtcomponents.php' => config_path('csgtcomponents.php'),
    ], 'config');

    $this->publishes([
        __DIR__ . '/../public' => public_path('packages/csgt/components'),
    ], 'public');
	}

	public function register() {
		$this->commands([
      Console\MakeComponentsCommand::class
    ]);

    $this->app->singleton('components', function($app) {
    	return new Components;
  	});
	}

	public function provides() {
		return array('components');
	}

}
