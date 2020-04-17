<?php

namespace blog\form;

/**
    permet d'hydrater  l'objet field avec les données que l'on a envoyé pour créer un formulaire
 */
abstract class Field 
{
    /**
    * On utilise le trait Hydrator afin que nos objets Field puissent être hydratés
    */
    use \blog\Hydrator;

    protected $errorMessage;
    protected $validators = [];
    protected $label;
    protected $name;
    protected $value;
    protected $type;

    public function __construct(array $options = [])
    {
        //print_r($options);
        if (!empty($options))
        {
            //print_r($options);
            //print_r($this->hydrate($options));
            $this->hydrate($options);
        }
    }

    abstract public function buildWidget();

    public function isValid()
    {
        //print_r("je rentre dans isValid de Field class");
        //print_r($this->validators);
        foreach ($this->validators as $validator)
        {
            //print_r("je rentre dans isValid de Field class");
            //print_r($this->validators);
            if (!$validator->isValid($this->value))
            {
                //print_r($this->value);
                $this->errorMessage = $validator->errorMessage();
                return false;
            }
        }

        return true;
    }
    
    //Getters
    public function label()
    {
        return $this->label;
    }

    public function name()
    {
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

    public function length()
    {
        return $this->length;
    }
    
    public function validators()
    {
        //print_r($this->validators);
        return $this->validators;
    }

    //Setters
    public function setLabel($label)
    {
        if (is_string($label))
        {
            $this->label = $label;
        }
    }

    public function setName($name)
    {
        //print_r($name);
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
            //print_r($value);
            $this->value = $value;
        }
    }

    public function setType($type)
    {
        if (is_string($type))
        {
            $this->type = $type;
        }
    }
    
    public function setLength($length)
    {
        $length = (int) $length;

        if ($length > 0)
        {
            $this->length = $length;
        }
    }
    
    public function setValidators(array $validators)
    {
        foreach ($validators as $validator)
        {
            if ($validator instanceof Validator && !in_array($validator, $this->validators))
            {
                $this->validators[] = $validator;
            }
        }
    }
}
