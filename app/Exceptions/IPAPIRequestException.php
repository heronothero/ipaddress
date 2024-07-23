<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class IPAPIRequestException extends Exception
{
    /**
     * Create a new exception instance
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(
        string $message = 'Ошибка выполнения запроса IP API', int $code = 0, Exception $previous = null
    ){
        parent::__construct($message, $code, $previous);
    }
}
