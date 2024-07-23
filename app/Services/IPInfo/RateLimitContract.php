<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

interface RateLimitContract
{
    /**
     * Summary of get
     * @return int
     */
    public function get(): int;

    /**
     * Summary of canMakeRequest
     * @return bool
     */
    public function canMakeRequest(): bool;

    /**
     * Summary of incrementRequestCount
     * @return int
     */
    public function incrementRequestCount(): int;
}
