<?php

namespace Nodus\Packages\LivewireCore;

use Illuminate\Support\ServiceProvider;

class LivewireCoreServiceProvider extends ServiceProvider
{
    private string $packageNamespace = 'nodus.packages.livewire-core';

    private string $resourcesPath = __DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR;

    public function boot()
    {
        $this->loadViewsFrom($this->resourcesPath . 'views', $this->packageNamespace);
    }
}
