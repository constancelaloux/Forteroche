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
        return $value != '';
    }

}
