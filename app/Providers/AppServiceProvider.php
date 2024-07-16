<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\RateLimitWorker;
use App\Services\IPInfo\RateLimit;
use App\Services\IPInfo\RateLimitContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RateLimitContract::class, function ($app) {
            return new RateLimit(40);
        });
        $this->commands([
            RateLimitWorker::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
