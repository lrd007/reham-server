<?php

namespace App\Providers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Modules\Program\Entities\Program;
use Nwidart\Modules\LaravelModulesServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        // URL::forceScheme('https');
        // Programs for navbar.
        view()->composer(['frontend.partials.navbar'], function ($view) {
            $view->with('programs', Program::all());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(LaravelModulesServiceProvider::class);
    }
}
