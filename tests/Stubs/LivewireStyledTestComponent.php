<?php

namespace Nodus\Packages\LivewireCore\Tests\Stubs;

use Livewire\Component;

class LivewireStyledTestComponent extends Component
{
    public static function styles(): string
    {
        return <<<CSS
            .test {
                margin: 0;
            }
        CSS;
    }
}
