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
  
    /**
     * 
     * @param type $errorMessage
     */
    public function __construct($errorMessage)
    {
        $this->setErrorMessage($errorMessage);
    }
  
    /**
     * 
     */
    abstract public function isValid($value);
  
    /**
     * 
     * @param type $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        if (is_string($errorMessage))
        {
          $this->errorMessage = $errorMessage;
        }
    }
  
    /**
     * 
     * @return type
     */
    public function errorMessage()
    {
        return $this->errorMessage;
    }  
}
