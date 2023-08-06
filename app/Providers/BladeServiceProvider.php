<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Custom @role directive
        Blade::directive('role', function ($role) {
            return "<?php if(auth()->check() && auth()->user()->role === {$role}): ?>";
        });

        // Custom @endrole directive
        Blade::directive('endrole', function () {
            return "<?php endif; ?>";
        });
    }
}
