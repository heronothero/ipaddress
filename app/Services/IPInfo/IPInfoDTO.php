<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

class IPInfoDTO
{
    /**
     * Summary of __construct
     * @param string $ip
     * @param string $type
     * @param mixed $country
     * @param mixed $countryCode
     * @param mixed $city
     * @param array $data
     */
    public function __construct(
        public string $ip,
        public string $type,
        public ?string $country = null,
        public ?string $countryCode = null,
        public ?string $city = null,
        public array $data = []
    ) {}
}
