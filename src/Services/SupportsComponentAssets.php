<?php

namespace Nodus\Packages\LivewireCore\Services;

trait SupportsComponentAssets
{
    public function styles(): string
    {
        $debug = config('app.debug');

        if (!isset($this->styledComponents) || count($this->styledComponents) === 0) {
            return '';
        }

        $html = $debug ? ['<!-- Livewire Package Styles -->'] : [];

        foreach ($this->styledComponents as $styledComponent) {
            if (!method_exists($styledComponent, 'styles')) {
                continue;
            }

            $styles = $styledComponent::styles();
            $html[] = $debug ? $styles : $this->minify($styles);
        }

        return implode("\n", $html);
    }

    protected function minify($content)
    {
        return preg_replace('~(\v|\t|\s{2,})~m', '', $content);
    }
}