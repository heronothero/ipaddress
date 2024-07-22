<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

class IPInfoDTO
{
    public function __construct(
        public string $ip,
        public string $type,
        public ?string $country = null,
        public ?string $countryCode = null,
        public ?string $city = null,
        public array $data = []
    ) {}
}
