<?php
declare(strict_types=1);
namespace App\Jobs;

use App\Exceptions\IPAPIRequestException;
use App\Services\IPInfo\IPAPIService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchIPInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * IP address to fetch ingfo for
     * @var string $ip
     */
    protected string $ip;

    /**
     * Create a new job instance
     * @param string $ip
     */
    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Summary of handle
     * @param IPAPIService $IPAPIService
     * @return void
     */
    public function handle(IPAPIService $IPAPIService)
    {
        try {
            $IPInfo = $IPAPIService->getIPInfo($this->ip);
            if ($IPInfo) {
                Log::info('Удачно получена информация об IP: ' . $this->ip, [
                    'ip_info' => $IPInfo
                ]);
            }
        } catch (IPAPIRequestException $e) {
            Log::error('Ошибка при получении данных об IP: ' . $this->ip, [
                'error' => $e->getMessage(),
                'exception' => $e
            ]);
        }
    }
}
