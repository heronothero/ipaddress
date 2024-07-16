<?php declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\RateLimitWorker;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::starting(function ($artisan) {
    $artisan->resolveCommands([
        RateLimitWorker::class,
    ]);
});

Artisan::command('rate-limit:process', function () {
    $this->comment('Рейт-лимит IP-адресов');
})->purpose('Рейт-лимит IP-адресов')->hourly();
