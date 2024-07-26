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
    /**
     * The HTTP client instance
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Summary of __construct
     *
     * @var RateLimitContract
     */
    protected RateLimitContract $rateLimit;

    /**
     * Summary of __construct
     *
     * @param RateLimitContract $rateLimit
     * @param Client|null $client
     */
    public function __construct(
        RateLimitContract $rateLimit,
        Client $client = null
        ){
            $this->rateLimit = $rateLimit;
            $this->client = $client ?? new Client();
        }

        /**
     * Get info about an IP address from getIPInfo
     *
     * @param string $ip
     * @throws RateLimitExceededExeption
     * @throws IPAPIRequestException
     * @return IPInfoDTO|null
     */
    public function getIPInfo(string $ip): ?IPInfoDTO
    {
        if (!$this->isIP($ip)) {
            return null;
        }
        $ipAddress = IPAddress::where('ip', $ip)->first();
        if ($ipAddress)
        {
            return $this->createIPInfoDTOFromModel($ipAddress);
        }
        if (!$this->rateLimit->canMakeRequest())
        {
            throw new RateLimitExceededExeption();
        }
        $this->rateLimit->incrementRequestCount();
        try {
            $data = $this->fetchIPData($ip);
        } catch (Exception $e) {
            throw new IPAPIRequestException('Ошибка извлечения IP информации', 0, $e);
        }
        $ipInfo = $this->createIPInfoDTOFromData($data);
        $this->saveIPInfo($ipInfo);
        return $ipInfo;
    }

    /**
     * Valid/invalid IP address
     * @param string $ip
     * @return bool
     */
    public function isIP (string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Save info about IP to db
     * @param IPInfoDTO $data
     * @return void
     */
    protected function saveIPInfo(IPInfoDTO $data): void
    {
        IPAddress::create([
            'ip' => $data -> ip,
            'type' => $data -> type,
            'country' => $data -> country,
            'countryCode' => $data -> countryCode,
            'city' => $data -> city,
            'data' => json_encode($data->data),
        ]);
    }

    /**
     * Create an IPInfoDTo from IPAddress model
     * @param IPAddress $ipAddress
     * @return IPInfoDTO
     */
    protected function createIPInfoDTOFromModel (IPAddress $ipAddress): IPInfoDTO
    {
        $data = json_decode($ipAddress->data, true);
        return new IPInfoDTO(
            $ipAddress->ip,
            $ipAddress->type,
            $ipAddress->country,
            $ipAddress->countryCode,
            $ipAddress->city,
            $data
        );
    }

    /**
     * Fetch IP data from external API
     * @param string $ip
     * @return array
     * @throws IPAPIRequestException
     */
    protected function fetchIPData(string $ip): array
    {
        try {
            $response = $this->client->get("http://ip-api.com/json/{$ip}");
            $data = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new IPAPIRequestException('Ошибка извлечения IP информации', 0, $e);
        }
        return array_merge([
            'query' => $ip,
                'isp' => 'Unknown ISP',
                'country' => null,
                'countryCode' => null,
                'city' => null
            ], $data);
    }

    /**
     * Create IPInfoDTO from fetched data
     * @param array $data
     * @return IPInfoDTO
     */
    protected function createIPInfoDTOFromData(array $data): IPInfoDTO
    {
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
        return new IPInfoDTO(
            $data['query'],
            $data['isp'],
            $data['country'],
            $data['countryCode'],
            $data['city'],
            $ipInfoData
        );
    }
}
