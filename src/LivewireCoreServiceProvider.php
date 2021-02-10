<?php

namespace Nodus\Packages\LivewireCore;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireCoreServiceProvider extends ServiceProvider
{
    private string $packageNamespace = 'nodus.packages.livewire-core';

    private string $resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR;

    public function boot()
    {
        $this->events();
        $this->loadViewsFrom($this->resourcesPath . 'views', $this->packageNamespace);
    }

    private function events()
    {
        Livewire::listen(
            'component.mount',
            function ($livewireClass, $parameter) {
                if (array_key_exists(SupportsAdditionalViewParameters::class, class_uses_recursive($livewireClass))) {
                    if (array_key_exists('additionalViewParameter', $parameter)) {
                        $livewireClass->checkAdditionalViewParameter($parameter[ 'additionalViewParameter' ]);
                    }
                }
            }
        );
    }
}
