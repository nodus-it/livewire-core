<?php

namespace Nodus\Packages\LivewireCore;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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

        $this->publishes([__DIR__ . '/config/livewire-core.php' => config_path('livewire-core.php')], 'livewire-core:config');
        $this->publishes([__DIR__ . '/resources/views' => resource_path('views/vendor/' . $this->packageNamespace)], 'livewire-core:views');

        $this->events();
        $this->bladeDirectives();
    }

    private function events()
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

    private function bladeDirectives()
    {
        Blade::directive('nonce', function () {
            return "<?php if(is_callable(config('livewire-core.csp_nonce'))) echo 'nonce=\"'.config('livewire-core.csp_nonce')().'\"'; ?>";
        });
    }
}
