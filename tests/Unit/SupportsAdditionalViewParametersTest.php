<?php

use Nodus\Packages\LivewireCore\Tests\Stubs\LivewireTestComponent;
use Nodus\Packages\LivewireCore\Tests\TestCase;

it('can access additional view parameters directly in the component', function () {
    livewire(LivewireTestComponent::class, ['additionalViewParameter' => ['test' => 1]])
        ->assertSet('test', 1)
        ->assertSee('Test Component');
});

it('falls back to null for not defined additional view parameters', function () {
    /** @var TestCase $this */
    $component = livewire(LivewireTestComponent::class, ['additionalViewParameter' => ['test' => 1]]);

    $this->assertNull($component->get('test2'));
});

it('prevents passing a additional view parameter with a conflicting name', function () {
    livewire(LivewireTestComponent::class, ['additionalViewParameter' => ['testProperty' => 2]]);
})->throws(Exception::class);
