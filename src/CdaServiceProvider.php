<?php

namespace Vinkas\Cda\Client;

use Illuminate\Support\ServiceProvider;

class CdaServiceProvider extends ServiceProvider
{
    public function boot()
    {
      $this->publishes([
          __DIR__.'/../config/cda.php' => config_path('cda.php'),
      ], 'cda-config');

      $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {
        $this->app->singleton(Cda::class);

        $this->mergeConfigFrom(
          __DIR__.'/../config/cda.php', 'cda'
      );
    }
}
