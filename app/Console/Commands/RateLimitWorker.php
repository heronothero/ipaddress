<?php declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\IPAddress;
use App\Services\IPInfo\IPAPIService;
use Illuminate\Support\Facades\Cache;

class RateLimitWorker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rate-limit:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обработка IP-адресов с превышением лимита скорости';
    protected $IPAPIService;
    public function __construct(IPAPIService $IPAPIService)
    {
        parent::__construct();
        $this->IPAPIService = $IPAPIService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rateLimitedIPs = Cache::get('rate_limited_ips', []);
        foreach ($rateLimitedIPs as $ip => $timestamp) {
            $ipInfo = $this->IPAPIService->getIPInfo($ip);
            if ($ipInfo) {
                $existingIp = IPAddress::where('ip', $ip)->first();
                if ($existingIp) {
                    $existingIp->update([
                        'type' => $ipInfo->type,
                        'country' => $ipInfo->country,
                        'countryCode' => $ipInfo->countryCode,
                        'city' => $ipInfo->city,
                        'data' => $ipInfo->data,
                    ]);
                } else {
                    IPAddress::create([
                        'ip' => $ip,
                        'type' => $ipInfo->type,
                        'country' => $ipInfo->country,
                        'countryCode' => $ipInfo->countryCode,
                        'city' => $ipInfo->city,
                        'data' => $ipInfo->data,
                    ]);
                }
            } else {
                $this->error("Ошибка извлечения данных: {$ip}");
            }
        }
        Cache::forget('rate_limited_ips');
        $this->info('Рейт-лимит IP-адресов прошел успешно');
    }
}
