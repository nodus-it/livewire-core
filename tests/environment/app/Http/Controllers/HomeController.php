<?php

namespace Nodus\Packages\LivewireCore\Tests\environment\app\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Nodus\Packages\LivewireCore\SupportsLivewire;
use Nodus\Packages\LivewireCore\Tests\environment\app\Providers\AppServiceProvider;

class HomeController extends Controller
{
    use SupportsLivewire, AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;

    public function overview()
    {
        $views = [];
        foreach (AppServiceProvider::getComponents() as $component) {
            $views[] = get_class($component);
        }
        return view('overview', ['views' => $views]);
    }

    public function show(string $view)
    {
        return $this->livewire($view)->layout('base')->section('content');
    }
}
