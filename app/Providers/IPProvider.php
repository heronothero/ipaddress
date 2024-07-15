<?php declare(strict_types=1);

namespace App\Providers;

use App\Services\IPInfo\IPAPIService;
use App\Services\IPInfo\IPInfoContract;
use Illuminate\Support\ServiceProvider;

class IPProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IPInfoContract::class, function () {
            return new IPAPIService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
