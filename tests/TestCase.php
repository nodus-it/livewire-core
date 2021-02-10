<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Livewire\LivewireServiceProvider;
use Nodus\Packages\LivewireCore\LivewireCoreServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            LivewireCoreServiceProvider::class,
        ];
    }
}
