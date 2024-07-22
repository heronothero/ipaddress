<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class RateLimitExceededExeption extends Exception
{
    protected $message = 'Рейт-лимит превышен';
    public function __construct()
    {
        parent::__construct($this->message);
    }
}
