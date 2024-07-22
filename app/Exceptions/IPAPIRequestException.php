<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class IPAPIRequestException extends Exception
{
    public function __construct(
        string $message = 'Ошибка выполнения запроса IP API', int $code = 0, Exception $previous = null
    ){
        parent::__construct($message, $code, $previous);
    }
}
