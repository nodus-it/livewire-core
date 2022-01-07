<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Illuminate\Http\Request;
use Nodus\Packages\LivewireCore\LivewireComponent;

class LivewireComponentTest extends TestCase
{
    public function testDefault()
    {
        $mock = $this->getMockBuilder('Nodus\Packages\LivewireCore\SupportsLivewire')->getMockForTrait();
        $livewire = $mock->livewire('component-name', ['parameter1' => 'a']);
        $this->assertInstanceOf(LivewireComponent::class, $livewire);
        $render = $livewire->render()->getData();
        $this->assertEquals('component-name', $render[ 'livewire__component_name' ]);
        $this->assertEquals(['parameter1' => 'a', 'additionalViewParameter' => []], $render[ 'livewire__parameter' ]);
        $this->assertEquals('content', $render[ 'livewire__section' ]);
        $this->assertEquals('layouts.app', $render[ 'livewire__layout' ]);
    }

    public function testLayoutParameter()
    {
        $mock = $this->getMockBuilder('Nodus\Packages\LivewireCore\SupportsLivewire')->getMockForTrait();
        $livewire = $mock->livewire('component-name', ['parameter1' => 'a']);
        $livewire->layoutParameter(['parameter2' => 'b']);
        $this->assertInstanceOf(LivewireComponent::class, $livewire);
        $render = $livewire->render()->getData();
        $this->assertArrayHasKey('parameter2', $render);
    }

    public function testToResponse()
    {
        $mock = $this->getMockBuilder('Nodus\Packages\LivewireCore\SupportsLivewire')->getMockForTrait();
        $livewire = $mock->livewire('component-name', ['parameter1' => 'a']);
        $this->assertEquals($livewire->render(), $livewire->toResponse(new Request()));
    }
}
