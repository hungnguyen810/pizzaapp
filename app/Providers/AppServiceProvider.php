<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() == 'local') {

            // Binding dev packages
            $this->registerDevPackages();
        }
    }

    public function registerDevPackages() {
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\GrahamCampbell\Exceptions\ExceptionsServiceProvider::class);
        $this->app->register(\Hesto\MultiAuth\MultiAuthServiceProvider::class);
        $this->app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
    }
}
