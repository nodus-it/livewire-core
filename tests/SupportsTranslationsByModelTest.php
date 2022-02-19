<?php

namespace Nodus\Packages\LivewireCore\Tests;

use Nodus\Packages\LivewireCore\Services\SupportsTranslationsByModel;

class SupportsTranslationsByModelTest extends TestCase
{
    use SupportsTranslationsByModel;

    protected string $model;

    /**
     * In order to test the protected methods of the SupportsTranslationsByModel trait we use the
     * trait directly in the test class and simply restore the trait related state before every test
     *
     * @return void
     */
    protected function resetTraitState()
    {
        $this->model = 'App\Models\UserRole';
    }

    public function testGetTranslationModelClass()
    {
        $this->resetTraitState();
        $this->assertEquals('App\Models\UserRole', $this->getTranslationModelClass());
    }

    public function testTranslationPrefix()
    {
        $this->resetTraitState();
        $this->assertEquals('user_roles', $this->getTranslationPrefix());
        $this->assertInstanceOf(self::class, $this->setTranslationPrefix('custom'));
        $this->assertEquals('custom', $this->getTranslationPrefix());
    }

    public function testTranslationStringByModel()
    {
        $this->resetTraitState();
        $this->assertEquals('user_roles.fields.name', $this->getTranslationStringByModel('fields.name'));
        $this->assertEquals('user_roles.fields.name', $this->getTranslationStringByModel('.fields.name'));
    }
}
