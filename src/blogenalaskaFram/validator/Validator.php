<?php
namespace blog\validator;

/**
 * Description of Validator
 *
 * @author constancelaloux
 */
abstract class Validator 
{
    protected $errorMessage;
  
    public function __construct($errorMessage)
    {
        $this->setErrorMessage($errorMessage);
    }
  
    abstract public function isValid($value);
  
    public function setErrorMessage($errorMessage)
    {
        //print_r($errorMessage);
        if (is_string($errorMessage))
        {
          $this->errorMessage = $errorMessage;
        }
    }
  
    public function errorMessage()
    {
        //print_r($this->errorMessage);
        return $this->errorMessage;
    }  
}
