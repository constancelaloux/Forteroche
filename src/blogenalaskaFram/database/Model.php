<?php

namespace blog\database;

use DateTime;

/**
 * Class Model
 * @package App\ORM
 */
class Model
{
    /**
     * @var array
     */
    public $originalData = [];
    
    protected $erreurs = [];
    
    /**
     * 
     * @param type $donnees
     */
    public function __construct($donnees = [])
    {
        if (!empty($donnees))
        {
            $this->hydrate($donnees);
        }
    }
    
    /**
     * @param array $result
     * @return Model
     * @throws ORMException
     */
    public function hydrate($result, ?array $model = null)
    {
        if(empty($result)) 
        {
            //throw new ORMException("Aucun résultat n'a été trouvé !");
        }
        $this->originalData = $result;

        foreach($this->originalData as $column => $value) 
        {
            $this->hydrateProperty($column, $value);
        }
        return $this;
    }

    /**
     * 
     * @param type $column
     * @param type $value
     */
    private function hydrateProperty($column, $value): void
    {
        if(isset($this::metadata()["table"]))
        {
                if(isset($this::metadata()["columns"][$column]))
                {
                    switch($this::metadata()["columns"][$column]["type"]) 
                    {
                        case "integer":
                            $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}((int) $value);
                            break;
                        case "string":
                            $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                            break;
                        case "datetime":
                            $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                            break;
                    }
                }
        }
    }

    /**
     * 
     * @param type $column
     * @return DateTime
     */
    public function getSQLValueByColumn($column)
    {
        $value = $this->{sprintf(ucfirst($this::metadata()["columns"][$column]["property"]))}();
        if($value instanceof \DateTime)
        {
            return $value->format("Y-m-d H:i:s");
        }
        return $value;
    }

    /**
     * 
     * @param type $value
     */
    public function setPrimaryKey($value)
    {
        $this->hydrateProperty($this::metadata()["primaryKey"], $value);
    }

    /**
     * get the id that will increment in the database
     * @return type
     */
    public function getPrimaryKey()
    {
        /**
         * I get the name of the primary key id
         */
        $primaryKeyColumn = $this::metadata()["primaryKey"];

        $property = $this::metadata()["columns"][$primaryKeyColumn]["property"];

        /**
         * I'm going to return the id getter
         */
        return $this->{sprintf(ucfirst($property))}();
    }

    /**
     * 
     * @return type
     */
    public function erreurs()
    {
        return $this->erreurs;
    }
}
