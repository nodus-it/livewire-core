<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Mockery;
use Nodus\Packages\LivewireCore\Services\CspNonce;

class CspNonceTest extends TestCase
{
    public function testCspNonceWithProvider()
    {
        $nonce = new CspNonce(fn() => 'abcdef12345');
        $this->assertIsCallable($nonce->getProvider());
        $this->assertTrue($nonce->providerExists());
        $this->assertEquals('abcdef12345', $nonce->get());
        $this->assertEquals('abcdef12345', $nonce->__toString());
        $this->assertEquals('nonce="abcdef12345"', $nonce->getHtmlAttribute());
        $this->assertEquals('nonce="abcdef12345"', $nonce->toHtml());
    }

    public function testCspNonceWithoutProvider()
    {
        $nonce = new CspNonce();
        $this->assertNull($nonce->getProvider());
        $this->assertFalse($nonce->providerExists());
        $this->assertNull($nonce->get());
        $this->assertEquals('', $nonce->__toString());
        $this->assertEquals('', $nonce->getHtmlAttribute());
        $this->assertEquals('', $nonce->toHtml());
    }

    public function testCspNonceSingleton()
    {
        $nonce = $this->app->get(CspNonce::class);
        $this->assertInstanceOf(CspNonce::class, $nonce);
    }

    public function testCspNonceBladeDirective()
    {
        $compiler = $this->app->get(BladeCompiler::class);
        $this->assertEquals(
            '<?php echo app(\Nodus\Packages\LivewireCore\Services\CspNonce::class)->toHtml() ?>',
            $compiler->compileString('@nonce')
        );
    }
}
