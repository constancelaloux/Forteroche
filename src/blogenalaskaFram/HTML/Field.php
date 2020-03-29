<?php

namespace blog\HTML;

/**
    permet d'hydrater  l'objet field avec les données que l'on a envoyé pour créer un formulaire
 */
abstract class Field 
{
    // On utilise le trait Hydrator afin que nos objets Field puissent être hydratés
    use Hydrator;

    protected $errorMessage;
    protected $label;
    protected $name;
    protected $value;
    protected $type;
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

    public function label()
    {
        return $this->label;
    }

    public function name()
    {
        print_r("je passe dans le getter");
        //print_r($this->name);
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }

    public function type()
    {
        return $this->type;
    }   

    public function action()
    {
        return $this->action;
    }
    
    public function method()
    {
        return $this->method;
    }

    public function setLabel($label)
    {
        if (is_string($label))
        {
            $this->label = $label;
        }
    }

    public function setName($name)
    {
        print_r("je passe dans le setter");
        if (is_string($name))
        {
            $this->name = $name;
        }
    }

    public function setValue($value)
    {
        //print_r($value);
        if (is_string($value))
        {
            $this->value = $value;
            //print_r($this->value);
        }
    }

    public function setType($type)
    {
        //print_r($value);
        if (is_string($type))
        {
            $this->type = $type;
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
