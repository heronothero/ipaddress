<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

use App\Models\IPAddress;
use GuzzleHttp\Client;
use App\Exceptions\RateLimitExceededExeption;
use App\Exceptions\IPAPIRequestException;
use Exception;
use App\Jobs\FetchIPInfo;

class IPAPIService implements IPInfoContract
{
    protected Client $client;
    public function __construct(
        protected RateLimitContract $rateLimit,
        Client $client = null
        ){
            $this->client = $client ?? new Client();
        }
    public function getIPInfo(string $ip): ?IPInfoDTO
    {
        if (!$this->isIP($ip)) {
            return null;
        }
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
                throw new RateLimitExceededExeption();
            }
            $this->rateLimit->incrementRequestCount();
            FetchIPInfo::dispatch($ip);
            try {
                $response = $this->client->get("http://ip-api.com/json/{$ip}");
                $data = json_decode($response->getBody()->getContents(), true);
            } catch (Exception $e) {
                throw new IPAPIRequestException('Ошибка извлечения IP информации', 0, $e);
            }
            $data = array_merge([
                'query' => $ip,
                'isp' => 'Unknown ISP',
                'country' => null,
                'countryCode' => null,
                'city' => null
            ], $data);
            $ipInfoData = [
                'continent' => $data['continent'] ?? null,
                'continentCode' => $data['continentCode'] ?? null,
                'region' => $data['region'] ?? null,
                'regionName' => $data['regionName'] ?? null,
                'district' => $data['district'] ?? null,
                'zip' => $data['zip'] ?? null,
                'lat' => $data['lat'] ?? null,
                'lon' => $data['lon'] ?? null,
                'timezone' => $data['timezone'] ?? null,
                'offset' => $data['offset'] ?? null,
                'currency' => $data['currency'] ?? null,
                'org' => $data['org'] ?? null,
                'as' => $data['as'] ?? null,
                'asname' => $data['asname'] ?? null,
                'reverse' => $data['reverse'] ?? null,
                'mobile' => $data['mobile'] ?? null,
                'proxy' => $data['proxy'] ?? null,
                'hosting' => $data['hosting'] ?? null,
            ];
            $ipInfo = new IPInfoDTO(
                $data['query'],
                $data['isp'],
                $data['country'],
                $data['countryCode'],
                $data['city'],
                $ipInfoData
            );
            $this->saveIPInfo($ipInfo);
            return $ipInfo;
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
