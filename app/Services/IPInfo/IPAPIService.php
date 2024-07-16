<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

class IPAPIService implements IPInfoContract
{
    public function getIPInfo(string $ip): ?IPInfoDTO
    {
        return null;
    }
    public function __construct(protected RateLimitContract $rateLimit)
    {
        //$this -> rateLimit -> get();
        return null;
    }
    public function isIP (string $ip): bool
    {
        return true;
    }
}
