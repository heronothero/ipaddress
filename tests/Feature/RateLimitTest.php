<?php
declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\IPInfo\RateLimitContract;
use App\Services\IPInfo\RateLimit;
use Illuminate\Support\Facades\Cache;

class RateLimitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }
    public function test_can_make_request_within_limit()
    {
        $rateLimiter = new RateLimit();
        $this->assertTrue($rateLimiter->canMakeRequest());
        $rateLimiter->incrementRequestCount();
        $this->assertTrue($rateLimiter->canMakeRequest());
    }
    public function test_cannot_make_request_after_limit_exceeded()
    {
        $rateLimiter = new RateLimit();
        Cache::put(RateLimit::KEY, 50);
        $this->assertFalse($rateLimiter->canMakeRequest());
    }
    public function test_request_count_resets_after_decay_period()
    {
        $rateLimiter = new RateLimit();
        Cache::put(RateLimit::KEY, 40, 1);
        $this->assertFalse($rateLimiter->canMakeRequest());
        sleep(61);
        $this->assertTrue($rateLimiter->canMakeRequest());
    }
}
