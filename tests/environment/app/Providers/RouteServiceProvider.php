<?php

namespace Nodus\Packages\LivewireCore\Tests\environment\app\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Nodus\Packages\LivewireCore\Tests\environment\app\Http\Controllers\HomeController;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

        $this->routes(function () {
            Route::get('/',[HomeController::class,'overview'])->name('overview');
            Route::get('/{view}',[HomeController::class,'show'])->name('show');
        });
    }
}
