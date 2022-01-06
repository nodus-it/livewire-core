<?php

namespace Nodus\Packages\LivewireCore;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Nodus\Packages\LivewireCore\Services\CspNonce;

class LivewireCoreServiceProvider extends ServiceProvider
{
    private string $packageNamespace = 'nodus.packages.livewire-core';

    private string $resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR;

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/livewire-core.php', 'livewire-core');
    }

    public function boot()
    {
        $this->loadViewsFrom($this->resourcesPath . 'views', $this->packageNamespace);

        $this->registerBindings();
        $this->registerLivewireEvents();
        $this->registerVendorPublishes();
        $this->registerBladeDirectives();
    }

    private function registerBindings()
    {
        $this->app->singleton(CspNonce::class, function () {
            return new CspNonce();
        });
    }

    private function registerLivewireEvents()
    {
        Livewire::listen(
            'component.mount',
            function ($livewireClass, $parameter) {
                if (
                    array_key_exists(SupportsAdditionalViewParameters::class, class_uses_recursive($livewireClass)) &&
                    array_key_exists('additionalViewParameter', $parameter)
                ) {
                    $livewireClass->checkAdditionalViewParameter($parameter[ 'additionalViewParameter' ]);
                }
            }
        );
    }

    private function registerVendorPublishes()
    {
        $this->publishes([__DIR__ . '/config/livewire-core.php' => config_path('livewire-core.php')], 'livewire-core:config');
        $this->publishes([__DIR__ . '/resources/views' => resource_path('views/vendor/' . $this->packageNamespace)], 'livewire-core:views');
    }

    private function registerBladeDirectives()
    {
        Blade::directive('nonce', function () {
            return "<?php echo app(\Nodus\Packages\LivewireCore\Services\CspNonce::class)->toHtml() ?>";
        });
    }
}
