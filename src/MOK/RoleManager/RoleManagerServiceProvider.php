<?php namespace MOK\RoleManager;

use Illuminate\Support\ServiceProvider;

class RoleManagerServiceProvider extends ServiceProvider {

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
    $this->package('MOK/RoleManager');

    require_once __DIR__.'/../../routes.php';
    require_once __DIR__.'/../../filters.php';

    $this->publishAssets();
  }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register the init command
    $this->app['command.rolemanager.init'] = $this->app->share(function($app)
    {
      return new InitCommand($app);
    });

    $this->commands(
      'command.rolemanager.init'
    );
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

  /**
   * Publish any CSS, JS and other assets this package needs
   */
  private function publishAssets()
  {
    // Auto-publish the assets when developing locally
    if ($this->app->environment() == 'local' && !$this->app->runningInConsole()) {
      $workbench = realpath(base_path().'/workbench');
      if (strpos(__FILE__, $workbench) === false) {
        $this->app->make('asset.publisher')->publishPackage('markokeeffe/role-manager');
      } else {
        $this->app->make('asset.publisher')->publishPackage('markokeeffe/role-manager', $workbench);
      }
    }
  }

}
