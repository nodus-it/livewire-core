<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Illuminate\Support\Facades\Config;
use Nodus\Packages\LivewireCore\Services\SupportsComponentAssets;
use Nodus\Packages\LivewireCore\Tests\stubs\LivewireTestComponent;
use Nodus\Packages\LivewireCore\Tests\stubs\LivewireStyledTestComponent;

class SupportsComponentAssetsTest extends TestCase
{
    public function testTraitDefault()
    {
        $mock = $this->getMockBuilder(SupportsComponentAssets::class)->getMockForTrait();
        $this->assertEquals('', $mock->styles());
    }

    public function testTraitWithoutStylesComponents()
    {
        $mock = $this->getMockBuilder(SupportsComponentAssets::class)->getMockForTrait();
        $mock->styledComponents = [LivewireTestComponent::class];

        $this->assertEquals('', $mock->styles());
    }

    public function testTraitInProductionMode()
    {
        Config::set('app.debug', false);
        $mock = $this->getMockBuilder(SupportsComponentAssets::class)->getMockForTrait();
        $mock->styledComponents = [LivewireStyledTestComponent::class];
        $css = $mock->styles();

        $this->assertEquals('.test {margin: 0;}', $css);
        $this->assertStringNotContainsString("\n", $css);
    }

    public function testTraitInDebugMode()
    {
        Config::set('app.debug', true);
        $mock = $this->getMockBuilder(SupportsComponentAssets::class)->getMockForTrait();
        $mock->styledComponents = [LivewireStyledTestComponent::class];
        $css = $mock->styles();

        $this->assertStringContainsString('margin: 0', $css);
        $this->assertStringContainsString("\n", $css);
    }

}
