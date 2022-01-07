<?php

namespace Nodus\Packages\LivewireCore;

use Illuminate\Support\Str;
use Livewire\Component;

trait SupportsLivewire
{
    /**
     * Create a new LivewireComponent instance
     *
     * @param string $componentNameOrClass Livewire component name or the FQCN of the component
     * @param array  $parameter            Livewire component parameter
     * @param array  $additionalViewParameter
     *
     * @return LivewireComponent
     */
    public function livewire(string $componentNameOrClass, array $parameter = [], array $additionalViewParameter = []): LivewireComponent
    {
        $componentName = $this->resolveLivewireComponentName($componentNameOrClass);

        if (!isset($parameter[ 'additionalViewParameter' ])) {
            $parameter[ 'additionalViewParameter' ] = $additionalViewParameter;
        }

        $livewireComponent = new LivewireComponent($componentName, $parameter);

        if (property_exists($this, 'defaultLayout')) {
            $livewireComponent->layout($this->defaultLayout);
        }

        if (property_exists($this, 'defaultSection')) {
            $livewireComponent->section($this->defaultSection);
        }

        if (method_exists($this, 'getLayoutData')) {
            $livewireComponent->layoutParameter($this->getLayoutData());
        }

        return $livewireComponent;
    }

    /**
     * Tries to resolve the component name from the given component class name
     *
     * @param string $componentClass
     *
     * @return string
     */
    private function resolveLivewireComponentName(string $componentClass)
    {
        if (!class_exists($componentClass) || !is_a($componentClass, Component::class, true)) {
            return $componentClass;
        }

        $componentClass = str_replace('App\\Http\\Livewire\\', '', $componentClass);
        $componentClassParts = array_map(
            function ($part) {
                return Str::kebab($part);
            },
            explode('\\', $componentClass)
        );

        return implode('.', $componentClassParts);
    }
}
