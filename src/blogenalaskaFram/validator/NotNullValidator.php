<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\validator;

use blog\validator\Validator;
/**
 * Description of NotNullValidator
 *
 * @author constancelaloux
 */
class NotNullValidator extends Validator
{

    public function isValid($value)
    {
      return $value != '';
    }

}
