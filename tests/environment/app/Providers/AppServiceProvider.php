<?php

namespace Nodus\Packages\LivewireCore\Tests\environment\app\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach (self::getComponents() as $component) {
            $parts = [];
            $ref = new \ReflectionClass($component);
            foreach (explode('\\', $ref->getNamespaceName()) as $part) {
                $parts[] = Str::kebab($part);
            }
            $parts[] = Str::kebab($ref->getShortName());
            $alias = implode('.', $parts);
            Livewire::component($alias, $component);
        }
    }

    public static function getComponents()
    {
        $components = [];

        if (!App::runningInConsole()) {
            foreach (File::files('../../../../../../tests/Data') as $report) {
                if (!str_ends_with($report->getFilename(), '.php')) {
                    continue;
                }

                try {
                    $className = str_replace('.php', '', $report->getFilename());
                    if (Str::contains($report->getRealPath(), 'livewire-forms')) {
                        $namespace = 'Nodus\Packages\LivewireForms\Tests\Data\\' . $className;
                    } else {
                        $namespace = 'Nodus\Packages\LivewireDatatables\Tests\Data\\' . $className;
                    }
                    /** @var Report $classInstance */
                    $classInstance = new $namespace();
                } catch (Throwable) {
                    continue;
                }

                $components[] = $classInstance;
            }
        }

        return $components;
    }
}
