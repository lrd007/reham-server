<?php

namespace Modules\Core\Providers;

use Exception;
use Illuminate\Support\ServiceProvider;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Repository as SettingRepository;
use Modules\Support\Locale;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Core';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'core';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        // $this->getSupportedLocales();
        // $this->setupAppTimezone();
        // $this->setupAppLocale();
        // $this->setupMailConfig();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton('setting', function () {
            return new SettingRepository(Setting::allCached());
        });
    }

    /**
     * Get supported locales from database.
     *
     * @return array
     */
    private function getSupportedLocales()
    {
        try {
            return Setting::get('supported_locales', [config('app.locale')]);
        } catch (Exception $e) {
            return [config('app.locale')];
        }
    }

    /**
     * Setup application timezone.
     *
     * @return void
     */
    private function setupAppTimezone()
    {
        $timezone = !empty(setting('default_timezone')) ? setting('default_timezone') : config('app.timezone');
        date_default_timezone_set($timezone);
        $this->app['config']->set('app.timezone', $timezone);
    }

    /**
     * Setup application locale.
     *
     * @return string
     */
    private function setupAppLocale()
    {
        $defaultLocale = !empty(Setting::get('default_locale')) ? Setting::get('default_locale') : 'en';

        $this->app['config']->set('app.locale', $defaultLocale);
        $this->app['config']->set('app.fallback_locale', $defaultLocale);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Setup application mail config.
     *
     * @return void
     */
    private function setupMailConfig()
    {
        $this->app['config']->set('mail.default', 'smtp');
        $this->app['config']->set('mail.from.address', setting('mail_from_address'));
        $this->app['config']->set('mail.from.name', setting('mail_from_name'));
        $this->app['config']->set('mail.mailers.smtp.host', setting('mail_host'));
        $this->app['config']->set('mail.mailers.smtp.port', setting('mail_port'));
        $this->app['config']->set('mail.mailers.smtp.username', setting('mail_username'));
        $this->app['config']->set('mail.mailers.smtp.password', setting('mail_password'));
        $this->app['config']->set('mail.mailers.smtp.encryption', setting('mail_encryption'));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
