<?php
declare(strict_types=1);

namespace App\Providers;

use App\Services\IPInfo\IPAPIService;
use App\Services\IPInfo\IPInfoContract;
use Illuminate\Support\ServiceProvider;
use App\Services\IPInfo\RateLimit;

class IPProvider extends ServiceProvider
{
    /**
     * Register function
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(IPInfoContract::class, function () {
            return new IPAPIService(new RateLimit(40));
        });
    }
    public function boot(): void
    {
        //
    }
}
