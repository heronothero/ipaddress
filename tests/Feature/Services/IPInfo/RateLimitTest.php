<?php
declare(strict_types=1);

namespace Tests\Feature\Services\IPInfo;

use Tests\TestCase;
use App\Services\IPInfo\RateLimitContract;
use App\Services\IPInfo\RateLimit;
use Illuminate\Support\Facades\Cache;

class RateLimitTest extends TestCase
{
    /**
     * Summary of setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    /**
     * Test that requests can be made within the limit
     */
    public function test_can_make_request_within_limit(): void
    {
        $rateLimiter = new RateLimit();
        $this->assertTrue($rateLimiter->canMakeRequest());
        $rateLimiter->incrementRequestCount();
        $this->assertTrue($rateLimiter->canMakeRequest());
    }

    /**
     * Test that requests cannot be made after the limit is exceeded
     */
    public function test_cannot_make_request_after_limit_exceeded(): void
    {
        $rateLimiter = new RateLimit();
        Cache::put(RateLimit::CACHE_KEY, 50);
        $this->assertFalse($rateLimiter->canMakeRequest());
    }

    /**
     * Test that the request count resets after the decay period
     */
    public function test_request_count_resets_after_decay_period(): void
    {
        $rateLimiter = new RateLimit();
        Cache::put(RateLimit::CACHE_KEY, 45, 60);
        $this->assertFalse($rateLimiter->canMakeRequest());
        sleep(61);
        $this->assertTrue($rateLimiter->canMakeRequest());
    }
}
