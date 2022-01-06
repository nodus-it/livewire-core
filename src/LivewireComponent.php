<?php

namespace Nodus\Packages\LivewireCore;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Livewire Component Class
 *
 * @package Nodus\Packages\LivewireCore
 */
class LivewireComponent implements Responsable
{
    /**
     * Livewire component name
     *
     * @var string
     */
    private string $componentName;

    /**
     * Livewire component parameters for mount
     *
     * @var array
     */
    private array $parameters;

    /**
     * Section name in extended layout
     *
     * @var string
     */
    private string $section = 'content';

    /**
     * Layout view name
     *
     * @var string
     */
    private string $layout = 'layouts.app';

    /**
     * Layout parameters
     *
     * @var array
     */
    private array $layoutParameters = [];

    /**
     * Creates a new LivewireComponent instance
     *
     * @param string $componentName Livewire component name
     * @param array  $parameter     Livewire component parameter
     *
     */
    public function __construct(string $componentName, array $parameter = [])
    {
        $this->componentName = $componentName;
        $this->parameters = $parameter;
    }

    /**
     * Sets the view section where the livewire component should be included
     *
     * @param string $section section name
     *
     * @return $this
     */
    public function section(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Sets the layout which livewire should extend
     *
     * @param string $layout           Layout name
     * @param array  $layoutParameters Array of layout parameters
     *
     * @return $this
     */
    public function layout(string $layout, array $layoutParameters = []): self
    {
        $this->layout = $layout;
        $this->layoutParameters = $layoutParameters;

        return $this;
    }

    /**
     * Sets the parameters used in the layout
     *
     * @param array $layoutParameters Layout parameters
     *
     * @return $this
     */
    public function layoutParameter(array $layoutParameters): self
    {
        $this->layoutParameters = $layoutParameters;

        return $this;
    }

    /**
     * Renders the view
     *
     * @return Factory|View
     */
    public function render()
    {
        $parameter = array_merge(
            $this->layoutParameters,
            [
                'livewire__component_name' => $this->componentName,
                'livewire__parameter'      => $this->parameters,
                'livewire__section'        => $this->section,
                'livewire__layout'         => $this->layout,
            ]
        );

        return view('nodus.packages.livewire-core::livewire.base-component', $parameter);
    }

    /**
     * Automatic response handling
     *
     * @param Request $request
     *
     * @return mixed|Response
     */
    public function toResponse($request)
    {
        return $this->render();
    }
}
