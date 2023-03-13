<?php

use Nodus\Packages\LivewireCore\Services\SupportsTranslationsByModel;
use Nodus\Packages\LivewireCore\Tests\TestCase;

it('returns the translation model class', function () {
    /** @var TestCase $this */
    $mock = $this->getMockForTrait(SupportsTranslationsByModel::class);
    $mock->model = 'App\Models\UserRole';
    $this->assertEquals('App\Models\UserRole', callMethod($mock, 'getTranslationModelClass'));
});

it('can change the translation prefix', function () {
    /** @var TestCase $this */
    $mock = $this->getMockForTrait(SupportsTranslationsByModel::class);
    $mock->model = 'App\Models\UserRole';
    $this->assertEquals('user_roles', callMethod($mock, 'getTranslationPrefix'));
    $this->assertInstanceOf(get_class($mock), callMethod($mock, 'setTranslationPrefix', 'custom'));
    $this->assertEquals('custom', callMethod($mock, 'getTranslationPrefix'));
});

it('returns the translations string in the model context', function () {
    /** @var TestCase $this */
    $mock = $this->getMockForTrait(SupportsTranslationsByModel::class);
    $mock->model = 'App\Models\UserRole';
    $this->assertEquals('user_roles.fields.name', callMethod($mock, 'getTranslationStringByModel', 'fields.name'));
    $this->assertEquals('user_roles.fields.name', callMethod($mock, 'getTranslationStringByModel', '.fields.name'));
});
