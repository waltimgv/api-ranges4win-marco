<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class DriverNotFound extends Exception
{

    public function __construct($message = 'Driver para validação não encontrado', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
