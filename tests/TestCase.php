<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Livewire\LivewireServiceProvider;
use Nodus\Packages\LivewireCore\LivewireCoreServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            LivewireCoreServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app[ 'config' ]->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
    }
}
