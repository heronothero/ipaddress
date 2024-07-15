<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

interface IPInfoContract
{
    public function getIPInfo(string $ip): ?IPInfoDTO;
}
