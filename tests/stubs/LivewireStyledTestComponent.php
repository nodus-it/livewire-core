<?php

namespace Nodus\Packages\LivewireCore\Tests\stubs;

use Livewire\Component;

class LivewireStyledTestComponent extends Component
{
    public static function styles()
    {
        return <<<CSS
            .test {
                margin: 0;
            }
        CSS;
    }
}