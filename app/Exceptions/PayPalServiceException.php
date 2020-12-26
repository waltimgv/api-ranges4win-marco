<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PayPalServiceException extends Exception
{

    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if ($message === '') {
            $message = config('app.debug') ? 'Connection timeout' : 'Some error occur, sorry for inconvenient';
        }

        parent::__construct($message, $code, $previous);
    }
    
}
