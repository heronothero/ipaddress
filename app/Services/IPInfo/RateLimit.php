<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

use Illuminate\Support\Facades\Cache;

class RateLimit implements RateLimitContract
{
    /**
     * CACHE_KEY for storing rate-limit count
     * @var string
     */
    public const CACHE_KEY = 'rate_limit';

    /**
     * The request limit
     * @var int
     */
    protected int $limit;

    /**
     * The ttl for cache
     * @var int
     */
    protected int $ttl;

    /**
     * Create a new RateLimit instancee
     * @param int $limit
     * @param int $ttl
     */
    public function __construct(int $limit = 40, int $ttl = 60)
    {
        $this->limit = $limit;
        $this->ttl = $ttl;
    }

    /**
     * Get the current number of requests frim cache
     * @return int
     */
    public function get(): int
    {
        return (int) Cache::get(static::CACHE_KEY, 0);
    }

    /**
     * If a new request can be made
     * @return bool
     */
    public function canMakeRequest(): bool
    {
        return $this->get() < $this->limit;
    }

    /**
     * Increment the request counter and update cache
     * @return int
     */
    public function incrementRequestCount(): int
    {
        $value = $this->get();
        Cache::put(static::CACHE_KEY, ++$value, $this->ttl);
        return $value;
    }
}
