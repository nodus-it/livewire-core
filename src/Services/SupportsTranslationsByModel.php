<?php

namespace Nodus\Packages\LivewireCore\Services;

use Illuminate\Support\Str;

trait SupportsTranslationsByModel
{
    /**
     * Custom translation prefix
     *
     * @var string|null
     */
    protected ?string $translationPrefix = null;

    /**
     * Returns the model class used for building the auto translation keys
     *
     * @return string|null
     */
    protected function getTranslationModelClass(): ?string
    {
        return $this->model;
    }

    /**
     * Sets the translation prefix
     *
     * @param string|null $prefix
     *
     * @return $this
     */
    protected function setTranslationPrefix(?string $prefix): self
    {
        $this->translationPrefix = $prefix;

        return $this;
    }

    /**
     * Returns the translation prefix
     *
     * @return string
     */
    protected function getTranslationPrefix(): string
    {
        if ($this->translationPrefix === null) {
            return (string)Str::of($this->getTranslationModelClass())->afterLast('\\')->snake()->plural();
        }

        return $this->translationPrefix;
    }

    /**
     * Generates a default translation string, based on model and column name
     *
     * @param string $lang Column name
     *
     * @return string
     */
    protected function getTranslationStringByModel(string $lang): string
    {
        return $this->getTranslationPrefix() . Str::start($lang, '.');
    }
}
