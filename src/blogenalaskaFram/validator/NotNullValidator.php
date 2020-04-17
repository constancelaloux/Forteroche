<?php

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
        print_r($value);
        die("je suis dans notNullValidator");
      return $value != '';
    }

}
