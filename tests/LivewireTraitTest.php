<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Nodus\Packages\LivewireCore\LivewireComponent;

class LivewireTraitTest extends TestCase
{
    public function testLivewireDefault()
    {
        $mock = $this->getMockBuilder('Nodus\Packages\LivewireCore\SupportsLivewire')->getMockForTrait();
        $this->assertInstanceOf(LivewireComponent::class, $mock->livewire('component-name', ['parameter1' => 'a']));
    }

    public function testLivewireWithDefaultLayout()
    {
        $mock = $this->getMockBuilder('Nodus\Packages\LivewireCore\SupportsLivewire')->getMockForTrait();
        $mock->defaultLayout = 'my-layout';
        $livewire = $mock->livewire('component-name', ['parameter1' => 'a']);
        $this->assertInstanceOf(LivewireComponent::class, $livewire);
        $this->assertEquals('my-layout', $livewire->render()->getData()[ 'livewire__layout' ]);
    }

    public function testLivewireWithDefaultSection()
    {
        $mock = $this->getMockBuilder('Nodus\Packages\LivewireCore\SupportsLivewire')->getMockForTrait();
        $mock->defaultSection = 'my-section';
        $livewire = $mock->livewire('component-name', ['parameter1' => 'a']);
        $this->assertInstanceOf(LivewireComponent::class, $livewire);
        $this->assertEquals('my-section', $livewire->render()->getData()[ 'livewire__section' ]);
    }
}
