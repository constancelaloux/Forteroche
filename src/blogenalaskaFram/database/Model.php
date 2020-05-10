<?php

namespace blog\database;

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
     * @return array
     */
    //public function metadata();
    
    /**
     * @return string
     */
    //public abstract static function getManager();
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
    public function hydrate($result)
    {
        if(empty($result)) 
        {
            //throw new ORMException("Aucun résultat n'a été trouvé !");
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
        //print_r($this::metadata()["columns"]);
        switch($this::metadata()["columns"][$column]["type"]) 
        {
            case "integer":
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}((int) $value);
                break;
            case "string":
                $this->{sprintf("set%s", ucfirst($this::metadata()["columns"][$column]["property"]))}($value);
                break;
            case "datetime":
                //print_r($column);
                //print_r($value);
                $datetime = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                //print_r($this::metadata()["columns"][$column]["property"]($datetime));
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
        $value = $this->{sprintf(ucfirst($this::metadata()["columns"][$column]["property"]))}();
        if($value instanceof \DateTime)
        {
            return $value->format("Y-m-d H:i:s");
        }
        return $value;
    }
    
    /**
     * @param mixed $value
     * j'obtient l'id qui va s'incrémenter en base de données
     */
    public function setPrimaryKey($value)
    {
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
        return $this->{sprintf(ucfirst($property))}();
    }
    
    /**
     * @return type
     */
    public function erreurs()
    {
        return $this->erreurs;
    }
}
