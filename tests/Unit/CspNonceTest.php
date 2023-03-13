<?php

use Illuminate\View\Compilers\BladeCompiler;
use Nodus\Packages\LivewireCore\Services\CspNonce;
use Nodus\Packages\LivewireCore\Tests\TestCase;

it('works with a provider function', function () {
    /** @var TestCase $this */
    $nonce = new CspNonce(fn () => 'abcdef12345');
    $this->assertIsCallable($nonce->getProvider());
    $this->assertTrue($nonce->providerExists());
    $this->assertEquals('abcdef12345', $nonce->get());
    $this->assertEquals('abcdef12345', $nonce->__toString());
    $this->assertEquals('nonce="abcdef12345"', $nonce->getHtmlAttribute());
    $this->assertEquals('nonce="abcdef12345"', $nonce->toHtml());
});

it('works without a provider function', function () {
    /** @var TestCase $this */
    $nonce = new CspNonce();
    $this->assertNull($nonce->getProvider());
    $this->assertFalse($nonce->providerExists());
    $this->assertNull($nonce->get());
    $this->assertEquals('', $nonce->__toString());
    $this->assertEquals('', $nonce->getHtmlAttribute());
    $this->assertEquals('', $nonce->toHtml());
});

it('is registered as singleton in the app container', function () {
    /** @var TestCase $this */
    $nonce = $this->app->get(CspNonce::class);
    $this->assertInstanceOf(CspNonce::class, $nonce);
});

it('works as the custom blade directive', function () {
    /** @var TestCase $this */
    $compiler = $this->app->get(BladeCompiler::class);
    $this->assertEquals(
        '<?php echo app(\Nodus\Packages\LivewireCore\Services\CspNonce::class)->toHtml() ?>',
        $compiler->compileString('@nonce')
    );
});
