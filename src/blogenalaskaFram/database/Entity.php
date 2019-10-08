<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\database;

use\PDO;
/**
 * Description of Entity
 *
 * @author constancelaloux
 */
abstract class Entity 
{
    protected $tableName;
    
    public function save() 
    {
        // this method construct sql using reflection 
        $class = new \ReflectionClass($this);
        $tableName = '';

        if ($this->tableName != '') {
            $tableName = $this->tableName;
        } 
        else 
        {
            $tableName = strtolower($class->getShortName());
        }
    } 
    
    /**
    * @return Entity
    */
    public static function morph(array $object) 
    {
        $class = new \ReflectionClass(get_called_class()); // this is static method that's why i use get_called_class

        $entity = $class->newInstance();

        foreach($class->getProperties(\ReflectionProperty::PUBLIC) as $prop) 
        {
            if (isset($object[$prop->getName()])) 
            {
                $prop->setValue($entity,$object[$prop->getName()]);
            }
        }

        $entity->initialize(); // soft magic

        return $entity;
    }
}
