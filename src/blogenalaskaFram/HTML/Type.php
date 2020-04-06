<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;

// On utilise le trait Hydrator afin que nos objets Field puissent être hydratés


abstract class Type 
{
    use Hydrator;
    protected $name;
    protected $action;
    protected $method;

    public function __construct(array $options = [])
    {
        //print_r($options);
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
        //print_r("je passe dans le getter");
        //print_r($this->name);
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
        //print_r("je passe dans le setter");
        if (is_string($name))
        {
            $this->name = $name;
        }
    }
  
    public function setAction($action)
    {
        //print_r($value);
        if (is_string($action))
        {
            $this->action = $action;
        }
    }
    
    public function setMethod($method)
    {
        //print_r($value);
        if (is_string($method))
        {
            $this->method = $method;
        }
    }
}
