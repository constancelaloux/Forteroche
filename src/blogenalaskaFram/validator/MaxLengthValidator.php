<?php

namespace blog\validator;

use blog\validator\Validator;
use RuntimeException;

/**
 * Description of MaxLengthValidator
 *
 * @author constancelaloux
 */
class MaxLengthValidator extends Validator
{
    protected $maxLength;

    /**
     * 
     * @param type $errorMessage
     * @param type $maxLength
     */
    public function __construct($errorMessage, $maxLength)
    {
        parent::__construct($errorMessage);

        $this->setMaxLength($maxLength);
    }

    /**
     * 
     * @param type $value
     * @return type
     */
    public function isValid($value)
    {
        return strlen($value) <= $this->maxLength;
    }

    /**
     * 
     * @param type $maxLength
     * @throws \RuntimeException
     */
    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0)
        {
            $this->maxLength = $maxLength;
        }
        else
        {
            throw new RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}
