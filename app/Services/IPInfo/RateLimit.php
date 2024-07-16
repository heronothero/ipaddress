<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

use Illuminate\Support\Facades\Cache;

class RateLimit implements RateLimitContract
{
    public function __construct(protected int $limit = 40)
    {

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
    protected function incrementRequestCount(): int
    {
        $value = $this -> get();
        Cache::put(static::KEY, ++$value);
        return $value;
    }
}
