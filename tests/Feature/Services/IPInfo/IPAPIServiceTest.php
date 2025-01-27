<?php
declare(strict_types=1);

namespace Tests\Feature\Services\IPInfo;

use Tests\TestCase;
use App\Services\IPInfo\IPAPIService;
use App\Services\IPInfo\RateLimit;
use App\Services\IPInfo\RateLimitContract;
use App\Models\IPAddress;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use App\Exceptions\RateLimitExceededExeption;
use App\Exceptions\IPAPIRequestException;

class IPAPIServiceTest extends TestCase
{
    /**
     *setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
        IPAddress::truncate();
    }

    /**
     * Test that gets IP info from db
     */
    public function testGetIPInfoFromDatabase()
    {
        $ip = '123.123.123.123';
        IPAddress::create([
            'ip' => $ip,
            'type' => 'ISP',
            'data' => json_encode([])
        ]);
        $rateLimitMock = $this->createMock(RateLimit::class);
        $rateLimitMock->method('canMakeRequest')->willReturn(true);
        $rateLimitMock->expects($this->never())->method('incrementRequestCount');
        $clientMock = $this->createMock(Client::class);
        $clientMock->method('get')->willReturn(new Response(200, [], json_encode([
            'query' => $ip,
            'isp' => 'ISP',
        ])));
        $service = new IPAPIService($rateLimitMock, $clientMock);
        $ipInfo = $service->getIPInfo($ip);
        $this->assertNotNull($ipInfo);
        $this->assertEquals($ip, $ipInfo->ip);
        $this->assertEquals('ISP', $ipInfo->type);
        $this->assertDatabaseHas('ip_address', [
            'ip' => $ip,
            'type' => 'ISP',
        ]);
    }

    /**
     * Test that checks when rate-limit exceeded
     */
    public function testRateLimitExceeded()
    {
        $this->expectException(RateLimitExceededExeption::class);
        $ip = '123.123.123.123';
        $rateLimitMock = $this->createMock(RateLimit::class);
        $rateLimitMock->method('canMakeRequest')->willReturn(false);
        $clientMock = $this->createMock(Client::class);
        $service = new IPAPIService($rateLimitMock, $clientMock);
        $service->getIPInfo($ip);
    }

    /**
     * Test that gets IP info from API
     */
    public function testGetIPInfoFromAPI()
    {
        $ip = '123.123.123.123';
        $responseBody = json_encode([
            'query' => $ip,
            'isp' => 'ISP'
        ]);
        $rateLimitMock = $this->createMock(RateLimit::class);
        $rateLimitMock->method('canMakeRequest')->willReturn(true);
        $rateLimitMock->expects($this->once())->method('incrementRequestCount');
        $clientMock = $this->createMock(Client::class);
        $clientMock->method('get')->willReturn(new Response(200, [], $responseBody));
        $service = new IPAPIService($rateLimitMock, $clientMock);
        $ipInfo = $service->getIPInfo($ip);
        $this->assertNotNull($ipInfo);
        $this->assertEquals($ip, $ipInfo->ip);
        $this->assertEquals('ISP', $ipInfo->type);
        $this->assertDatabaseHas('ip_address', [
            'ip' => $ip,
            'type' => 'ISP',
        ]);
    }

    /**
     * Test that checjs API request exception
     */
    public function testAPIRequestException()
    {
        $this->expectException(IPAPIRequestException::class);
        $ip = '123.123.123.123';
        $rateLimitMock = $this->createMock(RateLimit::class);
        $rateLimitMock->method('canMakeRequest')->willReturn(true);
        $rateLimitMock->expects($this->once())->method('incrementRequestCount');
        $clientMock = $this->createMock(Client::class);
        $clientMock->method('get')->willThrowException(new RequestException('Error', new \GuzzleHttp\Psr7\Request('GET', "http://ip-api.com/json/{$ip}")));
        $service = new IPAPIService($rateLimitMock, $clientMock);
        $service->getIPInfo($ip);
    }
}
