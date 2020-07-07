<?php

namespace blog\form;

use \blog\validator;

/**
 * Hydrate the field object with the datas that was sent to create a form
 */
abstract class Field 
{
    use \blog\Hydrator;

    protected $errorMessage;
    protected $validators = [];
    protected $label;
    protected $name;
    protected $value;
    protected $type;

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
        foreach ($this->validators as $validator)
        {
            if (!$validator->isValid($this->value))
            {
                $this->errorMessage = $validator->errorMessage();
                return false;
            }
        }

        return true;
    }
    
    /**
     * Getters
     */
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
        return $this->validators;
    }

    /**
     * Setters
     */
    public function setLabel($label)
    {
        if (is_string($label))
        {
            $this->label = $label;
        }
    }

    public function setName($name)
    {
        if (is_string($name))
        {
            $this->name = $name;
        }
    }

    public function setValue($value)
    {
        if (is_string($value))
        {
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
            if ($validator instanceof validator\Validator && !in_array($validator, $this->validators))
            {
                $this->validators[] = $validator;
            }
        }
    }
}
