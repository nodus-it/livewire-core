<?php

namespace Nodus\Packages\LivewireCore\Tests\Stubs;

use Livewire\Component;
use Nodus\Packages\LivewireCore\SupportsAdditionalViewParameters;

class LivewireTestComponent extends Component
{
    use SupportsAdditionalViewParameters;

    public int $testProperty = 1;

    public function render(): string
    {
        return <<<'blade'
            <div>Test Component</div>
        blade;
    }
}
