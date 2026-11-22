<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // @money($value) prints e.g. "৳ 1,250.00"
        Blade::directive('money', function ($expression) {
            return "<?php echo '৳ ' . number_format((float) ({$expression}), 2); ?>";
        });
    }
}