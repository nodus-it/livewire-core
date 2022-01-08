<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Nodus\Packages\LivewireCore\LivewireComponent;
use Nodus\Packages\LivewireCore\Tests\stubs\LivewireTestComponent;
use Nodus\Packages\LivewireCore\Tests\stubs\LivewireTestController;

class SupportsLivewireTest extends TestCase
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

    public function testLivewireWithDefaultLayoutParameters()
    {
        $mock = new LivewireTestController();
        $livewire = $mock->livewire('component-name');
        $this->assertInstanceOf(LivewireComponent::class, $livewire);
        $this->assertArrayHasKey('layoutParameterKey', $livewire->render()->getData());
    }

    public function testResolveLivewireComponentName()
    {
        $mock = new LivewireTestController();
        $livewire = $mock->livewire('my.component-name');
        $this->assertInstanceOf(LivewireComponent::class, $livewire);
        $this->assertEquals('my.component-name', $livewire->render()->getData()['livewire__component_name']);

        $livewire = $mock->livewire(LivewireTestComponent::class);
        $this->assertInstanceOf(LivewireComponent::class, $livewire);
        $this->assertEquals(
            'nodus.packages.livewire-core.tests.stubs.livewire-test-component',
            $livewire->render()->getData()[ 'livewire__component_name' ]
        );
    }
}
