<?php

use Illuminate\Support\Facades\Config;
use Nodus\Packages\LivewireCore\Services\SupportsComponentAssets;
use Nodus\Packages\LivewireCore\Tests\Stubs\LivewireTestComponent;
use Nodus\Packages\LivewireCore\Tests\Stubs\LivewireStyledTestComponent;
use Nodus\Packages\LivewireCore\Tests\TestCase;

class SupportsComponentAssetsMock {
    use SupportsComponentAssets;

    public array $styledComponents = [];
}

it('returns an empty string if no styled components are registered', function () {
    /** @var TestCase $this */
    $mock = new SupportsComponentAssetsMock();
    $this->assertEquals('', $mock->styles());
});

it('returns an empty string for a registered styled component without styles', function () {
    /** @var TestCase $this */
    $mock = new SupportsComponentAssetsMock();
    $mock->styledComponents = [LivewireTestComponent::class];

    $this->assertEquals('', $mock->styles());
});

it('returns the minified styles in disabled debug mode', function () {
    /** @var TestCase $this */
    Config::set('app.debug', false);
    $mock = new SupportsComponentAssetsMock();
    $mock->styledComponents = [LivewireStyledTestComponent::class];
    $css = $mock->styles();

    $this->assertEquals('.test {margin: 0;}', $css);
    $this->assertStringNotContainsString("\n", $css);
});

it('returns the unminified styles in enabled debug mode', function () {
    /** @var TestCase $this */
    Config::set('app.debug', true);
    $mock = new SupportsComponentAssetsMock();
    $mock->styledComponents = [LivewireStyledTestComponent::class];
    $css = $mock->styles();

    $this->assertStringContainsString('margin: 0', $css);
    $this->assertStringContainsString("\n", $css);
});
