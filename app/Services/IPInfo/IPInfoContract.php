<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

interface IPInfoContract
{
    /**
     * Summary of getIPInfo
     * @param string $ip
     * @return void
     */
    public function getIPInfo(string $ip): ?IPInfoDTO;

    /**
     * Summary of isIP
     * @param string $ip
     * @return bool
     */
    public function isIP (string $ip): bool;
}
