<?php

namespace App\Exceptions;

use Exception;

class UnprocessableEntityException extends Exception
{
    public function __construct($msg)
    {
        parent::__construct($msg);
    }
}
