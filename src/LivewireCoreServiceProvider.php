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

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/livewire-core.php', 'livewire-core');
    }

    public function boot(): void
    {
        $this->loadViewsFrom($this->resourcesPath . 'views', $this->packageNamespace);

        $this->registerBindings();
        $this->registerVendorPublishes();
        $this->registerBladeDirectives();
    }

    private function registerBindings(): void
    {
        $this->app->singleton(CspNonce::class, function () {
            return new CspNonce();
        });
    }

    private function registerVendorPublishes(): void
    {
        $this->publishes([__DIR__ . '/config/livewire-core.php' => config_path('livewire-core.php')], 'livewire-core:config');
        $this->publishes([__DIR__ . '/resources/views' => resource_path('views/vendor/' . $this->packageNamespace)], 'livewire-core:views');
    }

    private function registerBladeDirectives(): void
    {
        Blade::directive('nonce', function () {
            return "<?php echo app(\Nodus\Packages\LivewireCore\Services\CspNonce::class)->toHtml() ?>";
        });
    }
}
