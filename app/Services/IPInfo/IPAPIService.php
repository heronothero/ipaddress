<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

use App\Models\IPAddress;

class IPAPIService implements IPInfoContract
{
    public function __construct(protected RateLimitContract $rateLimit)
    {
        $this->rateLimit = $rateLimit;
    }
    public function getIPInfo(string $ip): ?IPInfoDTO
    {
        if ($this->isIP($ip)) {
            $ipAddress = IPAddress::where('ip', $ip)->first();
            if ($ipAddress)
            {
                return new IPInfoDTO(
                    $ipAddress->ip,
                    $ipAddress->type,
                    $ipAddress->country,
                    $ipAddress->countryCode,
                    $ipAddress->city,
                    $ipAddress->data
                );
            }
            if (!$this->rateLimit->canMakeRequest())
            {
                return null;
            }
            $this->rateLimit->incrementRequestCount();
            $response = file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);
            $data = array_merge([
                'query' => $ip,
                'isp' => 'Unknown ISP',
                'country' => null,
                'countryCode' => null,
                'city' => null
            ], $data);
            $ipInfo = new IPInfoDTO(
                $data['query'],
                $data['isp'],
                $data['country'],
                $data['countryCode'],
                $data['city'],
                $data
            );
            $this->saveIPInfo($ipInfo);
            return $ipInfo;
        }
        return null;
    }
    public function isIP (string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
    protected function saveIPInfo(IPInfoDTO $data): void
    {
        IPAddress::create([
            'ip' => $data -> ip,
            'type' => $data -> type,
            'country' => $data -> country,
            'countryCode' => $data -> countryCode,
            'city' => $data -> city,
            'data' => $data -> data,
        ]);
    }
}
