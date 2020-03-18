<?php

/**
 * Description of ValidatorError
 *
 * @author constancelaloux
 */
class ValidatorError 
{
    private $key;
    
    private $rule;
    
    private $message = ['required' => 'Le champs %s est requis',
        'empty' => 'Le champs %s ne peut etre vide',
        'slug' => 'Le champs %s n \'est pas un slug valide',
        'minlength' => 'Le champs %s doit contenir plus de %d caractéres',
        'maxlength' => 'Le champs %s doit contenir moins de %d caractéres',
        'beetweenlength' => 'Le champs %s doit etre entre %d caractéres et %d caractéres',
        'datetime' => 'Le champs %s doit étre une date valide (%s)'
        ];
    /**
    *@var array
    */
    private $attributes;
    
    public function __construct(string $key, string $rule, array $attributes = []) 
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }
    
    public function __toString()
    {
        $params = array_merge([$this->message[$this->key], $this->key], $this->attributes);
        return (string)call_user_func_array('sprintf', $params);
    }
}
