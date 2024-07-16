<?php
declare(strict_types=1);

namespace App\Providers;

use App\Services\IPInfo\IPAPIService;
use App\Services\IPInfo\IPInfoContract;
use App\Services\IPInfo\RateLimit;
use App\Services\IPInfo\RateLimitContract;
use Illuminate\Support\ServiceProvider;

class IPProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IPInfoContract::class, function () {
            return new IPAPIService(RateLimit(40));
        });
    }
    public function boot(): void
    {
        //
    }
}
