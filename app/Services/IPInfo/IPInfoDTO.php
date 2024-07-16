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

    public function __construct(
        string $ip,
        string $type,
        ?string $country = null,
        ?string $countryCode = null,
        ?string $city = null,
        array $data = []
    )
    {
        $this -> ip = $ip;
        $this -> type = $type;
        $this -> country = $country;
        $this -> countryCode = $countryCode;
        $this -> city = $city;
        $this -> data=$data;
    }
}
