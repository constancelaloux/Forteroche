<?php

namespace blog\database;

use blog\database\DbConnexion;
use blog\database\Model;

/**
 * Description of Query
 *
 * @author constancelaloux
 */
class Query extends DbConnexion
{
    /**
     * @var \PDO
     */
    protected $pdo;
    
    /**
     * @var type 
     */
    private $select;
    
    /**
     * @var type 
     */
    private $from;
    
    /**
     * @var type 
     */
    private $where = [];
    
    /**
     * @var type 
     */
    private $group;
    
    /**
     * @var type 
     */
    private $order;
    
    /**
     * @var type 
     */
    private $limit;
    
    /**
     * @var type 
     */
    private $joins;
    
    /**
     * @var type 
     */
    private $params;
    
    /**
     * @var type 
     */
    private $model;
    
    /**
     * @param Model $model
     * @throws ORMException
     */
    public function __construct(Model $model)
    {
        //Je me connecte à la base de données
        $this->pdo = $this->connect();
        
        //Ensuite je récupare le nom de la class objet
        $reflectionClass = new \ReflectionClass($model);
        
        if($reflectionClass->getParentClass()->getName() == Model::class) 
        {
            $this->model = $model;
            //Je récupére si chaque composants de ma class test est un int ou un string, etc
            $this->metadata = $this->model::metadata();
        }
        else
        {
            throw new ORMException("Cette classe n'est pas une entité.");
        }
        $this->model = $model;
    }
    

    /**
     * @param string $table
     * @param string $alias
     * @return \self
     */
    public function from(string $table, string $alias = null): self
    {
        $this->from = $alias === null ? $table : "$table $alias";
        return $this;
    }
    
    /**
     * @param type $field
     * @return \self
     */
    public function select(string ...$field): self
    {
        $fields = implode(', ', $field);
        $this->select = $fields;
        return $this;
    }
    
    /**
     * Permet de spécifier la limit
     * @param int $length
     * @param int $offset
     * @return Query
     */
    public function limit(int $length, int $offset = 0): self
    {
        $this->limit = "$offset, $length";
        return $this;
    }
    
    /**
     * @param string $key
     * @param string $direction
     * @return \self
     */
    public function orderBy(string $key, string $direction): self
    {
        $direction = strtoupper($direction);
        if(!in_array($direction, ['ASC', 'DESC']))
        {
            $this->order[] = $key;
        }
        else 
        {
            $this->order[] = "$key $direction";
        }
        return $this;
    }
    
    /**
     * Ajoute une liaison
     * @param string $table
     * @param string $condition
     * @param string $type
     * @return Query
     */
    public function join(string $table, string $condition, string $type = "left"): self
    {
        $this->joins[$type][] = [$table, $condition];
        return $this;
    }
    
    /**
     * Définit la condition de récupération
     * @param string $where
     * @return \self
     */
    public function where(string $where): self
    {
        $this->where = $where;
        return $this;
    }
    
    /**
     * 
     * @return int
     */
    public function count(): int
    {
        $this->select("COUNT(id)");
        return $this->execute()->fetchColumn();
    }
    
    /**
     * 
     * @param string $key
     * @param type $value
     * @return \self
     */
    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;
        return $this;
    }
    
    /**
     * 
     * @param string $entity
     * @return \self
     */
    public function into(string $entity): self
    {
        $this->entity = $entity;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function toSQL(): string
    {
        $sql = NULL;
        
        if ($this->select)
        {
            $sql .= " SELECT " . $this->select;
        }
        else 
        {
            $sql .=  " SELECT " . '*';
            
        }
        if($this->from)
        {
            $sql .= " FROM " . $this->from;
        }
        if(!empty($this->joins))
        {
            foreach ($this->joins as $type => $joins) 
            {
                //foreach ($joins as $table => $condition) 
                foreach ($joins as $condition) 
                    //print_r($condition[0]);
                {
                    //print_r(strtoupper($type).' '."JOIN $table ON $condition");
                    $sql .= ' '.strtoupper($type).' '. "JOIN $condition[0] ON $condition[1]";
                }
            }
        }
        if($this->where)
        {
            $sql .= " WHERE " . $this->where;
        }
        if(!empty($this->order))
        {
            $sql .= " ORDER BY " . implode(', ', $this->order);
        }
        if($this->limit !== null)
        {
            $sql .= " LIMIT " . $this->limit;
        }  
        /*if($this->offset !== null)
        {
            $sql .= " OFFSET " . $this->offset;
        }*///;
        return $sql;
    }
    
    public function fetchAll(): ?array
    {
        $query = $this->toSQL();
        //print_r($query);
        if($this->params)
        {
            $query = $this->pdo->prepare($query);
            $query->execute($this->params);
            //$query->setFetchMode(\PDO::FETCH_CLASS, \blog\entity\Author::class);
            //$query->setFetchMode(\PDO::FETCH_CLASS, \blog\entity\Comment::class);
            //$results = $query->fetchAll(\PDO::FETCH_ASSOC);
            $results = $query->fetchAll(\PDO::FETCH_CLASS);
            //$results = $query->fetchAll(\PDO::FETCH_OBJ);
            //$results = $query->fetchAll();
            //echo "<pre>";
            //var_dump($results);
            //die('meurs');
            //$results = $query->fetchAll(\PDO::FETCH_ASSOC);
            //$results = $query->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_CLASSTYPE);
            //$resultat = $query->fetchAll(\PDO::FETCH_ASSOC);
                
                /*echo '<pre>';
                print_r($results);
                echo '</pre>';*/
                
            //print_r($results);
            //DIE("MEURS");
            return $results;
            /*$data = [];*/
        
            /*foreach($results as $result) 
            {
                $data[] = (new $this->model())->hydrate($result);
            }
            print_r($this->model);*/
           /* return $data;*/
        }
        //return (new $this->model($result));
        //return NULL;
        
    }
    
    /**
     * Construit le from a as b ....
     * @return string
     */
    private function buildFrom(): string
    {
        $from = [];
        foreach ($this->from as $key => $value)
        {
            if(is_string($key))
            {
                $from[] = "$value as $key";
            }
            else
            {
                $from[] = $value;
            }
        }
        return join(', ', $from);
    }
}

    /**
     * 
     * @return type
     */
    /*private function execute()
    {
        //$query = $this->__toString();
        $query = $this->toSQL();
        if($this->params)
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($this->params);
            return $statement;
        }
        return $this->pdo->query($query);
    }*/



   /**
     * 
     * @return type
     */
    /*public function __toString() 
    {
        $parts = ['SELECT'];
        if ($this->select)
        {
            $parts[] = join(', ', $this->select);
        }
        else 
        {
            $parts[] = '*';
        }
        $parts[] = 'FROM';
        $parts[] = $this->buildFrom();
        if(!empty($this->joins))
        {
            foreach($this->joins as $type => $joins)   
            {
                foreach ($joins as $table => $condition) 
                {
                    $parts[] = strtoupper($type) . " $table ON $condition";
                }
            }
        }
        
        if(!empty($this->joins))
        {
            foreach ($this->joins as $type => $joins) 
            {
                foreach ($joins as $table => $condition) 
                {
                    $parts[] = strtoupper($type). "JOIN $table ON $condition";
                }
            }
        }
        
        if(!empty($this->where))
        {
            $parts[] = 'WHERE';
            $parts[] = "(' . join(') AND (', $this->where) . ')";
        }
        
        if(!empty($this->order))
        {
            $parts[] = 'ORDER BY';
            $parts[] = join(', ', $this->order);
        }
        if($this->limit)
        {
            $parts[] = 'LIMIT' . $this->limit;
        }
        return join(' ', $parts);
    }*/



    /**
     * 
     * @param string $table
     * @param string $alias
     * @return \self
     */
    /*public function from(string $table, string $alias = null): self
    {
        if($alias)
        {
            $this->from[$alias] = $table;
            //print_r($this->from[$alias]);
        }
        else
        {
            $this->from[] = $table;
        }
        print_r($this);
        return $this;
    }*/


    
        /**
     * 
     * @param int $offset
     * @return \self
     */
    /*public function offset(int $offset): self
    {
        if($this->limit === null)
        {
            throw new Exception("impossible de définir un offset sans définir de limites");
        }
        $this->offset = $offset;
        return $this;
    }*/
    
    /**
     * Spécifie l'odre de récupération
     * @param array $order
     * @return Query
     */
    /*public function order(string $order): self
    {
        $this->order[] = $order;
        return $this;
    }*/

    /*public function where(string ...$condition): self
    {
        $this->where = array_merge($this->where, $condition);
        return $this;
    }*/

    /**
     * 
     * @param array $params
     * @return \self
     */
    /*public function params(array $params):self
    {
        $this->params = $params;
        return $this;
    }*/
