<?php

use Illuminate\Http\Request;
use Nodus\Packages\LivewireCore\LivewireComponent;
use Nodus\Packages\LivewireCore\SupportsLivewire;
use Nodus\Packages\LivewireCore\Tests\Stubs\LivewireTestComponent;
use Nodus\Packages\LivewireCore\Tests\Stubs\LivewireTestController;
use Nodus\Packages\LivewireCore\Tests\TestCase;

it('can be accessed all livewire layout data', function () {
    /** @var TestCase $this */
    $livewire = $this->getMockForTrait(SupportsLivewire::class)->livewire('component-name', ['parameter1' => 'a']);
    $this->assertInstanceOf(LivewireComponent::class, $livewire);
    $render = $livewire->render()->getData();
    $this->assertEquals('component-name', $render['livewire__component_name']);
    $this->assertEquals(['parameter1' => 'a', 'additionalViewParameter' => []], $render['livewire__parameter']);
    $this->assertEquals('content', $render['livewire__section']);
    $this->assertEquals('layouts.app', $render['livewire__layout']);
});

it('can be added additional layout parameters', function () {
    /** @var TestCase $this */
    $livewire = $this->getMockForTrait(SupportsLivewire::class)->livewire('component-name', ['parameter1' => 'a']);
    $livewire->layoutParameter(['parameter2' => 'b']);
    $this->assertInstanceOf(LivewireComponent::class, $livewire);
    $render = $livewire->render()->getData();
    $this->assertArrayHasKey('parameter2', $render);
});

it('is responsable', function () {
    /** @var TestCase $this */
    $livewire = $this->getMockForTrait(SupportsLivewire::class)->livewire('component-name', ['parameter1' => 'a']);
    $this->assertEquals($livewire->render(), $livewire->toResponse(new Request()));
});


test('the default layout can be changed', function () {
    /** @var TestCase $this */
    $mock = $this->getMockForTrait(SupportsLivewire::class);
    $mock->defaultLayout = 'my-layout';
    $livewire = $mock->livewire('component-name', ['parameter1' => 'a']);
    $this->assertInstanceOf(LivewireComponent::class, $livewire);
    $this->assertEquals('my-layout', $livewire->render()->getData()['livewire__layout']);
});

test('the default section can be changed', function () {
    /** @var TestCase $this */
    $mock = $this->getMockForTrait(SupportsLivewire::class);
    $mock->defaultSection = 'my-section';
    $livewire = $mock->livewire('component-name', ['parameter1' => 'a']);
    $this->assertInstanceOf(LivewireComponent::class, $livewire);
    $this->assertEquals('my-section', $livewire->render()->getData()['livewire__section']);
});

test('the default layout parameters can be set in the controller', function () {
    /** @var TestCase $this */
    $mock = new LivewireTestController();
    $livewire = $mock->livewire('component-name');
    $this->assertInstanceOf(LivewireComponent::class, $livewire);
    $this->assertArrayHasKey('layoutParameterKey', $livewire->render()->getData());
});

it('can resolve components by name', function () {
    /** @var TestCase $this */
    $mock = new LivewireTestController();
    $livewire = $mock->livewire('my.component-name');
    $this->assertInstanceOf(LivewireComponent::class, $livewire);
    $this->assertEquals('my.component-name', $livewire->render()->getData()['livewire__component_name']);
});

it('can resolve components by class', function () {
    /** @var TestCase $this */
    $mock = new LivewireTestController();
    $livewire = $mock->livewire(LivewireTestComponent::class);
    $this->assertInstanceOf(LivewireComponent::class, $livewire);
    $this->assertEquals(
        'nodus.packages.livewire-core.tests.stubs.livewire-test-component',
        $livewire->render()->getData()['livewire__component_name']
    );
});
