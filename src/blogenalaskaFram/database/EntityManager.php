<?php

namespace blog\database;

use blog\database\DbConnexion;
use blog\database\Model;

/**
 * Class Manager
 */
class EntityManager extends DbConnexion
{
    /**
     * @var \PDO
     */
    protected $pdo;
    /**
     * @var string
     */
    private $model;
    /**
     * @var array
     */
    private $metadata;
    
    //Je récupére dans le constructeur ce que j'ai fait passer à ma class test
    public function __construct(Model $model)
    {
        //print_r($model);
        //Je me connecte à la base de données
        $this->pdo = $this->connect();
        
        //Ensuite je récupare le nom de la class objet
        $reflectionClass = new \ReflectionClass($model);
        
        if($reflectionClass->getParentClass()->getName() == Model::class) 
        {
            $this->model = $model;
            //print_r($this->model);
            //Je récupére si chaque composants de ma class test est un int ou un string, etc
            $this->metadata = $this->model::metadata();
            //print_r($this->metadata);
        }
        else
        {
            throw new ORMException("Cette classe n'est pas une entité.");
        }
        $this->model = $model;
        
    }
    
    /**
     * sql queries
     */
    
    /**
     * Persist datas before to send them in database
     * It goes to update or insert if there is a primary key or not
     * @param Model $model
     */
    public function persist(Model $model)
    {
        //print_r("je passe dans persist");
        if($model->getPrimaryKey()) 
        {
            $this->update($model);
        }
        else
        {
            $this->insert($model);
        }
    }
    
    /**
     * Update datas in database
     * @param Model $model
     */
    private function update(Model &$model)
    {
        $set = [];
        $parameters = [];
        
        foreach(array_keys($this->metadata["columns"]) as $column)
        {
            $sqlValue = $model->getSQLValueByColumn($column);
            
            /*if($sqlValue !== $model->originalData[$column]) 
            {*/
            $model->orignalData[$column] = $sqlValue;
            //$model->originalData[$column];
            $parameters[$column] = $sqlValue;
            //print_r($parameters[$column]);
            $set[] = sprintf("%s = :%s", $column, $column);
            //}
            //print_r($model);
        }
        if(count($set)) 
        {
            $sqlQuery = sprintf("UPDATE %s SET %s WHERE %s = :id", $this->metadata["table"], implode(", ", $set), $this->metadata["primaryKey"]);
            $statement = $this->pdo->prepare($sqlQuery);
            //print_r($parameters);
            //die("meurs");
            //$statement->execute(["id" => $model->getPrimaryKey()]);
            $statement->execute($parameters);
            //print_r($statement->execute(["id" => $model->getPrimaryKey()]));
        }
    }
    
    /**
     * Insert datas in database
     * @param Model $model
     */
    private function insert(Model &$model)
    {
        //print_r($model);
        //print_r("je passe dans insert");
        //print_r($model);
        $set = [];
        $parameters = [];

        foreach(array_keys($this->metadata["columns"]) as $column)
        {
            //print_r($column);
            $sqlValue = $model->getSQLValueByColumn($column);
            //print_r($sqlValue);
            $model->orignalData[$column] = $sqlValue;
            $parameters[$column] = $sqlValue;
            //print_r($parameters[$column]);

            $set[] = sprintf("%s = :%s", $column, $column);
            //print_r($set);
        }
        
        $sqlQuery = sprintf("INSERT INTO %s SET %s", $this->metadata["table"], implode(",", $set));

        $statement = $this->pdo->prepare($sqlQuery);

        $statement->execute($parameters);
        //print_r($statement->execute($parameters));

        $model->setPrimaryKey($this->pdo->lastInsertId());
    }
    
    /**
     * Remove datas in database
     * @param Model $model
     */
    public function remove(Model $model)
    {
        $sqlQuery = sprintf("DELETE FROM %s WHERE %s = :id", $this->metadata["table"], $this->metadata["primaryKey"]);
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute(["id" => $model->getPrimaryKey()]);
    }
    
    /**
     * Check if there is lines with attributes we need exists in database
     * @param type $filters
     * @return type
     */
    public function exist($filters = [])
    {
        $sqlQuery = sprintf("SELECT COUNT(*) FROM %s %s ", $this->metadata["table"], $this->where($filters));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        //return (bool) $statement->fetchColumn();
        return $statement->fetchColumn();
    }
    
    /**
     * find prend un unique paramètre et recherche l'argument dans la clé primaire de l'entité.
     * 
     * findBy prend 4 paramètres ($criteria, $orderBy, $limit, $offset). 
     * Cette méthode retourne des résultats correspondant aux valeurs des clés demandées.
     * 
     * findAll est un alias de findBy([]). Il retourne par conséquent tous les résultats.
     * 
     * findOneBy fonctionne comme la méthode findBy mais retourne un unique résultat et non pas un tableau.
     * 
     * La méthode __call étant implémentée dans les EntityRepository, sachez que si vous appelez findByUser, 
     * que cette méthode n'a pas été définie dans votre repository et que vous disposez d'un champ user dans 
     * votre entité, vous effectuerez une recherche sur ce même champ uniquement.
     */
    
    /**
     * Check if the is a line in database which correspond to the id we ve put in args
     * La méthodefind($id)récupère tout simplement l'entité correspondante à l'id$id
     * @param type $id
     * @return type
     */
    public function findById($id)
    {
        return $this->fetch([$this->metadata["primaryKey"] => $id]);
    }
    
    /**
     * La méthodefindOneBy(array $criteria, array $orderBy = null)
     * fonctionne sur le même principe que la méthodefindBy(), 
     * sauf qu'elle ne retourne qu'une seule entité. 
     * Les argumentslimitetoffsetn'existent donc pas. 
     * @param type $filters
     * @return type
     */
    public function findOneBy($filters = [])
    {
        return $this->fetch($filters);
    }
    
    /**
     * @param type $filters
     * @return type
     */
    public function fetch($filters = [])
    {
        $sqlQuery = sprintf("SELECT * FROM %s %s LIMIT 0,1", $this->metadata["table"], $this->where($filters));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        //return (new $this->model())->hydrate($result);
        return (new $this->model($result));
        //return (new $this->model())->hydrate($result);
    }
    
    /**
     * Requéte que l'on va utiliser pour récupérer nos articles
     * FindAll method goes to fetchAll
     * La méthode findAll()retourne toutes les entités contenue dans la base de données.
     *  Le format du retour est un tableau PHP normal (un array), que vous pouvez parcourir 
     * (avec unforeachpar exemple) pour utiliser les objets qu'il contient
     * @return type
     */
    public function findAll()
    {
        return $this->fetchAll();
    }
    
    /**
     * find a line or many lines with a spécify arg
     * La méthodefindBy()est un peu plus intéressante. CommefindAll(), elle permet de retourner une liste d'entités, 
     * sauf qu'elle est capable d'effectuer un filtre pour ne retourner que les entités correspondant à 
     * un ou plusieurs critère(s). Elle peut aussi trier les entités, et même n'en récupérer 
     * qu'un certain nombre (pour une pagination).
     * @param type $filters
     * @param type $orderBy
     * @param type $length
     * @param type $start
     * @return type
     */
    public function findBy($filters = [], $orderBy = [], $desc = null, $length = null, $start = null)
    {
        return $this->fetchAll($filters, $orderBy, $desc, $length, $start);
    }
    
    /**
     * Vous connaissez le principe des méthodes magiques, 
     * comme__call()qui émule des méthodes. Ces méthodes émulées 
     * n'existent pas dans la classe, elle sont prises en charge par__call()qui va exécuter du code en 
     * fonction du nom de la méthode appelée.
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public function __call($name, $arguments)
    {
        if(preg_match("/^findOneBy([A-Za-z]+)$/", $name, $matches)) {
            return $this->findOneBy([$matches[1] => $arguments[0]]);
        }
        elseif(preg_match("/^findBy([A-Za-z]+)$/", $name, $matches)) {
            $arguments[1] = $arguments[1] ?? [];
            $arguments[2] = $arguments[2] ?? null;
            $arguments[3] = $arguments[3] ?? null;
            return $this->fetchAll([$matches[1] => $arguments[0]], $arguments[1], $arguments[2], $arguments[3]);
        }
    }
    
    /**
     * La méthode findAll retourne toutes les catégories de la base de données
     * @param type $filters
     * @param type $sorting
     * @param type $length
     * @param type $start
     * @return type
     */
    private function fetchAll($filters = [] ,$sorting = [], $length = null, $start = null)
    {   
        //print_r($filters);
        //print_r($sorting);
        //print_r($length);
        $sqlQuery = sprintf("SELECT * FROM %s %s %s %s", $this->metadata["table"], $this->where($filters), $this->orderBy($sorting), $this->limit($length, $start));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        //print_r($statement);
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $data = [];
        
        foreach($results as $result) 
        {
            $data[] = (new $this->model())->hydrate($result);
            //return (new $this->model())->hydrate($result);
        }
        return $data;
    }
    
    /**
     * Use in sql request to give an args
     * @param type $filters
     * @return string
     */
    private function where($filters = [])
    {
        if(!empty($filters))
        {
            $conditions = [];
            foreach($filters as $property => $value) 
            {
                $conditions[] = sprintf("%s = :%s",$this->getColumnByProperty($property), $property);
            }
            return sprintf("WHERE %s", implode($conditions, " AND "));
        }
        return "";
    }
    
    /**
     * Spécifie l'odre de récupération
     * @param type $sorting
     * @return string
     */
    private function orderBy($sorting = [])
    {
        if(!empty($sorting)) 
        {
            $sorts = [];
            foreach($sorting as $property => $value) 
            {
                //print_r($property);
                $sorts[] = sprintf("%s %s",$this->getColumnByProperty($property), $value);
                //print_r($sorts);
            }
            return sprintf("ORDER BY %s DESC", implode($sorts, ","));
            //return sprintf("ORDER BY %", implode($sorts, ","));
        }
        return "";
    }
    
    /**
     * 
     * @param type $property
     * @return type
     */
    public function getColumnByProperty($property)
    {
        $property = lcfirst($property);
        $columns = array_keys(array_filter($this->metadata["columns"], function($column) use ($property) 
        {
            return $column["property"] == $property;
        }));
        $column = array_shift($columns);
        return $column;
    }
    
    /**
     * Can specify the limit
     * @param type $length
     * @param type $start
     * @return string
     */
    public function limit($length, $start)
    {
        if($length !== null) 
        {
            if($start !== null) 
            {
                return sprintf("LIMIT %s,%s", $start, $length);
            }
            return sprintf("LIMIT %s", $length);
        }
        return "";
    }
    
    /*public function find($filters = [])
    {
        return $this->read($filters);
    }
           
    private function read($filters = [])
    {
        $sqlQuery = sprintf("SELECT * FROM %s %s", $this->metadata["table"], $this->where($filters));
        $statement = $this->pdo->prepare($sqlQuery);
        $statement->execute($filters);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        //var_dump($result);
        return (new $this->model())->hydrate($result);
        //return (new $this->model($result));
    } */
    
}
