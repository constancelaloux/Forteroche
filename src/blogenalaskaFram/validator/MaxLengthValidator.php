<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\validator;

use blog\validator\Validator;
/**
 * Description of MaxLengthValidator
 *
 * @author constancelaloux
 */
class MaxLengthValidator extends Validator
{
    protected $maxLength;

    public function __construct($errorMessage, $maxLength)
    {
        //print_r($errorMessage);
        //print_r($maxLength);
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    public function isValid($value)
    {
        return strlen($value) <= $this->maxLength;
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0)
        {
            $this->maxLength = $maxLength;
        }
        else
        {
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}
