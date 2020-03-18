<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\database;

/**
 * Class Model
 * @package App\ORM
 */
abstract class Model
{
    /**
     * @var array
     */
    public $originalData = [];
    /**
     * @return array
     */
    public abstract static function metadata();
    
    /**
     * @return string
     */
    //public abstract static function getManager();
    /**
     * @param array $result
     * @return Model
     * @throws ORMException
     */
    public function hydrate($result)
    {
        //print_r("je suis dans la fonction hydrate de Model");
        //die('meurs');
        if(empty($result)) 
        {
            throw new ORMException("Aucun résultat n'a été trouvé !");
        }
        $this->originalData = $result;
        foreach($result as $column => $value) 
        {
            $this->hydrateProperty($column, $value);
        }
        return $this;
    }
    /**
     * @param string $column
     * @param mixed $value
     */
    private function hydrateProperty($column, $value)
    {
        //print_r("je suis dans la foncton hydrate property");
        switch($this::metadata()["columns"][$column]["type"]) 
        {
            case "integer":
                //print_r("je passe dans integer");
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}((int) $value);
                break;
            case "string":
                //print_r("je passe dans string");
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                break;
            case "datetime":
                //print_r("je passe dans datetime");
                $datetime = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($datetime);
                break;
        }
    }
    /**
     * @param string $column
     * @return mixed
     */
    public function getSQLValueByColumn($column)
    {
        //print_r($column);
        //print_r("je suis dans la fonction getSQLValueByColumn");
        //print_r($this::metadata()["columns"][$column]["property"]);
        $value = $this->{sprintf("get%s", ucfirst($this::metadata()["columns"][$column]["property"]))}();
        //print_r($value);
        if($value instanceof \DateTime)
        {
            return $value->format("Y-m-d H:i:s");
        }
 
       // die("meurs");
        return $value;
    }
    /**
     * @param mixed $value
     * j'obtient l'id qui va s'incrémenter en base de données
     */
    public function setPrimaryKey($value)
    {
        //print_r($value);
        //die("meurs");
        $this->hydrateProperty($this::metadata()["primaryKey"], $value);
    }
    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        //Je récupére le nom de la clé primaire 'id
        $primaryKeyColumn = $this::metadata()["primaryKey"];

        $property = $this::metadata()["columns"][$primaryKeyColumn]["property"];
        //Je vais retourner le getter de l'id
        //print_r($this->{sprintf("get%s", ucfirst($property))}());
        return $this->{sprintf("get%s", ucfirst($property))}();
    }
}
