<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\database;

use \blog\database\Model;


class test extends Model
{

    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;
    
    /**
    * @ORM\Column(name="age", type="int")
    */
    protected $age;

    /**
    * @ORM\Column(name="title", type="string", length=255)
    */
    protected $test;
  
    /**
    * @ORM\Column(name="title", type="string", length=255)
    */
    protected $name;

        /**
     * @inheritdoc
     */
    public static function metadata()
    {
        return [
            "table"             => "test",
            "primaryKey"        => "id",
            "columns"           => [
                "id"            => [
                    "type"      => "integer",
                    "property"  => "id"
                ],
                "age"            => [
                    "type"      => "integer",
                    "property"  => "age"
                ],
                "test"            => [
                    "type"      => "string",
                    "property"  => "test"
                ],
                "name"            => [
                    "type"      => "string",
                    "property"  => "name"
                ],
            ]
        ];
    }
    
    /**
    * @inheritdoc
    */
    public static function getManager()
    {
        return;
    }
    
    /**
    * Getters
    */

    /**
    * Get the user id.
    * @return int
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    * Get the user test.
    * @return string
    */
    public function getTest()
    {
        return $this->test;
    }
    
    /**
    * Get the user age.
    * @return string
    */
    public function getAge()
    {
        return $this->age;  
    }
    
    /**
    * Get the user name.
    * @return string
    */
    public function getName()
    {
        return $this->name;  
    }
  
    /**
    * Setters
    */
    
        /**
    * Set the user id.
    *
    * @param  in  $id
    * @return int
    */
    public function setId($id)
    {
        $id = (int) $id;
        //print_r($id);

        if ($id > 0)
            {
                $this->id = $id;
            }
    }
    
    /**
    * Set the user age.
    *
    * @param  string  $age
    * @return string
    */
    public function setAge($age)
    {
        //On vérifie qu'il s'agit bien d'un int
        if(is_int($age))
            {
                //L'attribut de l'admin manager sera = a $test. 
                //Il aura la valeur de la variable $test
                $this->age = $age;
                //print_r($this->age);
            }
    }
    
    /**
    * Set the user name.
    *
    * @param  string  $name
    * @return string
    */
    public function setName($name)
    {
        //On vérifie qu'il s'agit bien d'un int
        if(is_string($name))
            {
                //L'attribut de l'admin manager sera = a $test. 
                //Il aura la valeur de la variable $test
                $this->name = $name;
                //print_r($this->name);
            }
    }
    
    
    /**
    * Set the user test.
    *
    * @param  string  $test
    * @return string
    */
    public function setTest($test)
    {
        //On vérifie qu'il s'agit bien d'une chaine de caractéres
        if(is_string($test))
            {
                //L'attribut de l'admin manager sera = a $test. 
                //Il aura la valeur de la variable $test
                $this->test = $test;
                //print_r($this->test);
            }
    }
}
