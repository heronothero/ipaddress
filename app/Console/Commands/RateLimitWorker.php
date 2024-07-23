<?php
declare(strict_types=1);

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

    /**
     * The IPAPIService instance
     *
     * @var IPAPIService
     */
    protected IPAPIService $IPAPIService;

    /**
     * Create a new command instance
     *
     * @param IPAPIService $IPAPIService
     */
    public function __construct(IPAPIService $IPAPIService)
    {
        parent::__construct();
        $this->IPAPIService = $IPAPIService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $rateLimitedIPs = Cache::get('rate_limited_ips', []);
        foreach ($rateLimitedIPs as $ip => $timestamp) {
            $this->processIP($ip);
        }
        Cache::forget('rate_limited_ips');
        $this->info('Рейт-лимит IP-адресов прошел успешно');
    }

    /**
     * Process a single IP address
     *
     * @param string $ip
     * @return void
     */
    protected function processIP(string $ip): void
    {
        $ipInfo = $this->IPAPIService->getIPInfo($ip);
        if ($ipInfo) {
            $this->updateOrCreateIPAddress($ip, $ipInfo);
        } else {
            $this->error("Ошибка извлечения данных: {$ip}");
        }
    }

    /**
     * Update or create IP address
     *
     * @param string $ip
     * @param object $ipInfo
     * @return void
     */
    protected function updateOrCreateIPAddress(string $ip, object $ipInfo): void
    {
        $existingIP = IPAddress::where('ip', $ip)->first();
        $data = [
            'type' => $ipInfo->type,
            'country' => $ipInfo->country,
            'countryCode' => $ipInfo->countryCode,
            'city' => $ipInfo->city,
            'data' => $ipInfo->data,
        ];
        if ($existingIP) {
            $existingIP->update($data);
        } else {
            IPAddress::create(array_merge(['ip' => $ip], $data));
        }
    }
}
