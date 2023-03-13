<?php

namespace Nodus\Packages\LivewireCore\Tests\Stubs;

use Nodus\Packages\LivewireCore\SupportsLivewire;

class LivewireTestController
{
    use SupportsLivewire;

    public function getLayoutData(): array
    {
        return ['layoutParameterKey' => 'a'];
    }
}
