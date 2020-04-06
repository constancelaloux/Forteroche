<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\validator;

use blog\validator\Validator;

/**
 * Description of MinLengthValidator
 *
 * @author constancelaloux
 */
class MinLengthValidator extends Validator
{
    protected $minLength;

    public function __construct($errorMessage, $minLength)
    {
        //print_r($errorMessage);
        //print_r($maxLength);
        parent::__construct($errorMessage);

        $this->setMinLength($minLength);
    }

    public function isValid($value)
    {
        return strlen($value) <= $this->minLength;
    }

    public function setMinLength($minLength)
    {
        $minLength = (int) $minLength;

        if ($minLength > 0)
        {
            $this->minLength = $minLength;
        }
        else
        {
            throw new \RuntimeException('La longueur minimale doit être un nombre supérieur à 0');
        }
    }
}
