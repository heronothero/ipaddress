<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

class IPAPIService implements IPInfoContract
{
    public function getIPInfo(string $ip): ?IPInfoDTO
    {
        return null;
    }
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
}
