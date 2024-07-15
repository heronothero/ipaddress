<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

class IPInfoDTO
{
    public string $ip;
    public string $type;
    public ?string $country;
    public ?string $countryCode;
    public ?string $city;
    public array $data;

    public function __construct()
    {
        //
    }
}
