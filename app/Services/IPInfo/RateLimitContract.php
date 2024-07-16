<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

interface RateLimitContract
{
    public function get(): int;
    public function canMakeRequest(): bool;
    public function incrementRequestCount(): int;
}
