<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

use Illuminate\Support\Facades\Cache;

class RateLimit implements RateLimitContract
{
    public function __construct(protected int $limit = 40, protected int $ttl = 60)
    {
        $this->limit = $limit;
        $this->ttl = $ttl;
    }
    public const KEY = 'rate_limit';
    public function get(): int
    {
        return (int)Cache::get(static::KEY, 0);
    }
    public function canMakeRequest(): bool
    {
        return $this -> get() < $this -> limit;
    }
    public function incrementRequestCount(): int
    {
        $value = $this -> get();
        Cache::put(static::KEY, ++$value, $this -> ttl);
        return $value;
    }
}
