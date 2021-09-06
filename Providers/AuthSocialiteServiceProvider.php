<?php

namespace Modules\AuthSocialite\Providers;

use Illuminate\Support\ServiceProvider;

class AuthSocialiteServiceProvider extends ServiceProvider
{

    /**
     * @var string $moduleName
     */
    protected $moduleName = 'AuthSocialite';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'authsocialite';

    /**
     * Boot the application events.
     *
     * @return void
     */

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    public function boot()
    {
        //
    }


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
