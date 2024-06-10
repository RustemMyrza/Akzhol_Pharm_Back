<?php

namespace App\Exceptions;

use Exception;

class ApiErrorException extends Exception
{
    /**
     * @param string $message
     * @param int $status
     */
    public function __construct(string $message = '', int $status = 500)
    {
        parent::__construct($message, $status);
    }
}
