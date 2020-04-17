<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace blog\exceptions;

class ServiceNotFoundException extends \Exception
{
    public function __construct(string $path)
    {

    }
}
