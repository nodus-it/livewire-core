<?php

namespace Nodus\Packages\LivewireCore\Tests\stubs;

use Livewire\Component;
use Nodus\Packages\LivewireCore\SupportsAdditionalViewParameters;

class LivewireTestComponent extends Component
{
    use SupportsAdditionalViewParameters;

    public function render()
    {
        return <<<'blade'
            <div>Test Component</div>
        blade;
    }
}