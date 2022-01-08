<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Livewire\Livewire;
use Nodus\Packages\LivewireCore\Tests\stubs\LivewireTestComponent;

class SupportsAdditionalViewParametersTest extends TestCase
{
    public function testTraitDefault()
    {
        $component = Livewire::test(LivewireTestComponent::class, ['additionalViewParameter' => ['test' => 1]])
            ->assertSet('test', 1)
            ->assertSee('Test Component');

        $this->assertNull($component->get('test2'));
    }

    public function testTraitException()
    {
        $this->expectException(\Exception::class);
        Livewire::test(LivewireTestComponent::class, ['additionalViewParameter' => ['id' => 2]]);
    }
}
