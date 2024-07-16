<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

use App\Models\IPAddress;

class IPAPIService implements IPInfoContract
{
    public function __construct(protected RateLimitContract $rateLimit)
    {
        $this->rateLimit = $rateLimit;
    }
    public function getIPInfo(string $ip): ?IPInfoDTO
    {
        if ($this->isIP($ip)) {
            return IPAddress::where('ip', $ip)->first();
        }
        if (!$this->rateLimit->canMakeRequest()) {
            return null;
        }
        $this->rateLimit->incrementRequestCount();
        return null;
    }
    public function isIP (string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    protected function saveIPInfo(array $data): void
    {
        IPAddress::create($data);
    }
}
