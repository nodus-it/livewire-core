<?php

namespace Nodus\Packages\LivewireCore\Services;

use Illuminate\Contracts\Support\Htmlable;
use Stringable;

class CspNonce implements Htmlable, Stringable
{
    /**
     * CSP Nonce provider function
     *
     * @var callable|string
     */
    protected $provider;

    public function __construct($provider = null)
    {
        $this->provider = $provider ?? config('livewire-core.csp_nonce');
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function providerExists(): bool
    {
        return is_callable($this->provider);
    }

    public function get()
    {
        if (!$this->providerExists()) {
            return null;
        }

        return ($this->provider)();
    }

    public function getHtmlAttribute(): string
    {
        if (!$this->providerExists()) {
            return '';
        }

        return 'nonce="' . $this->get() . '"';
    }

    public function toHtml()
    {
        return $this->getHtmlAttribute();
    }

    public function __toString()
    {
        return $this->get() ?? '';
    }
}