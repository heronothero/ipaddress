<?php
declare(strict_types=1);

namespace App\Services\IPInfo;

use Illuminate\Support\Facades\Cache;

class RateLimit implements RateLimitContract
{
    //Ключ для хранекния ограничения запросов в кеше
    public const CACHE_KEY = 'rate_limit';
    //Инициализация лимита кол-ва запросов и времени жизни записи в кеше
    public function __construct(
        protected int $limit = 40,
        protected int $ttl = 60
        ) {}
    //Получение текущего кол-ва запросов из кеша
    public function get(): int
    {
        return (int) Cache::get(static::CACHE_KEY, 0);
    }
    //Провекра возможности выполнения нового запроса
    public function canMakeRequest(): bool
    {
        return $this->get() < $this->limit;
    }
    //Счетчик увеличения запросов и обновление значения в кеше
    public function incrementRequestCount(): int
    {
        $value = $this->get();
        Cache::put(static::CACHE_KEY, ++$value, $this->ttl);
        return $value;
    }
}
