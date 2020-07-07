<?php

namespace blog\exceptions;
use Exception;

class ServiceNotFoundException extends Exception
{
    public function __construct(string $path)
    {

    }
}
