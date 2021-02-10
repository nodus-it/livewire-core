<?php


namespace Nodus\Packages\LivewireCore;


use Exception;

trait SupportsAdditionalViewParameters
{
    /**
     * @var array Additional view parameter
     */
    public array $additionalViewParameter = [];


    public function __get($property)
    {
        if (array_key_exists($property, $this->additionalViewParameter)) {
            return $this->additionalViewParameter[ $property ];
        }

        return null;
    }

    public function checkAdditionalViewParameter(array $additionalViewParameter)
    {
        foreach ($additionalViewParameter as $parameter => $value) {
            if (property_exists($this, $parameter)) {
                throw new Exception('Invalid additionalViewParameter name: "' . $parameter . '". This name is reserved for ' . self::class);
            }
        }

        $this->additionalViewParameter = $additionalViewParameter;
    }
}
