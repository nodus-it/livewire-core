<?php

namespace Nodus\Packages\LivewireCore\Tests\stubs;

use Nodus\Packages\LivewireCore\SupportsLivewire;

class LivewireTestController
{
    use SupportsLivewire;

    public function getLayoutData()
    {
        return ['layoutParameterKey' => 'a'];
    }
}