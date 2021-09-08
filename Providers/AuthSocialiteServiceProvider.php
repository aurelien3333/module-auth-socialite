<?php

namespace Modules\AuthSocialite\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\BaseCore\Contracts\Services\CompositeurThemeContract;
use Modules\BaseCore\Contracts\Views\AfterLoginContract;
use Modules\BaseCore\Entities\TypeView;

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
        $this->registerViews();
        $this->registerConfig();
        app(CompositeurThemeContract::class)->setViews(AfterLoginContract::class, [
        new TypeView(TypeView::TYPE_LIVEWIRE, 'authsocialite::btn-auth-google')
    ]);
    }

    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
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

    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }


}
