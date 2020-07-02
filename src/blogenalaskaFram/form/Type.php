<?php

namespace blog\form;

abstract class Type 
{
    use \blog\Hydrator;
    protected $name;
    protected $action;
    protected $method;
    
    protected $value;

    public function __construct(array $options = [])
    {
        if (!empty($options))
        {
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget();

    public function isValid()
    {
        // On écrira cette méthode plus tard.
    }

    public function name()
    {
        return $this->name;
    }  

    public function action()
    {
        return $this->action;
    }
    
    public function method()
    {
        return $this->method;
    }

    public function setName($name)
    {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }
  
    public function setAction($action)
    {
        if (is_string($action))
        {
            $this->action = $action;
        }
    }
    
    public function setMethod($method)
    {
        if (is_string($method))
        {
            $this->method = $method;
        }
    }
    
    public function setValue($value)
    {
        if (is_string($value))
        {
            $this->value = $value;
        }
    }
}
