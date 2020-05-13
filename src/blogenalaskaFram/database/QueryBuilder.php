<?php

namespace blog\database;

use PDO;
use \Exception;

/**
 * Description of QueryBuilder
 *
 * @author constancelaloux
 */
class QueryBuilder 
{
    /**
     *
     * @var type 
     */
    private $from;
    
    /**
     *
     * @var type 
     */
    private $order = [];
    
    /**
     *
     * @var type 
     */
    private $limit;
    
    /**
     *
     * @var type 
     */
    private $offset;
    
    /**
     *
     * @var type 
     */
    private $where;
    
    /**
     *
     * @var type 
     */
    private $fields = ["*"];
    
    /**
     *
     * @var type 
     */
    private $params = [];
    
    /**
     *
     * @var type 
     */
    private $pdo;
    
    /**
     * 
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo = null)
    {
        $this->pdo = pdo;   
    }
    
    /**
     * 
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
     * 
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
     * 
     * @param int $limit
     * @return \self
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * 
     * @param int $offset
     * @return \self
     */
    public function offset(int $offset): self
    {
        if($this->limit === null)
        {
            throw new Exception("impossible de définir un offset sans définir de limites");
        }
        $this->offset = $offset;
        return $this;
    }
    
    /**
     * 
     * @param int $page
     * @return \self
     */
    public function page(int $page): self
    {
        return $this->offset($this->limit * ($page - 1));
    }
    
    /**
     * 
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
     * @param type $fields
     * @return \self
     */
    public function select(string ...$fields): self
    {
        if(is_array($fields[0]))
        {
            $fields = $fields[0];
        }
        if($this->fields === ['*'])
        {
            $this->fields = $fields;
        }
        else
        {
            $this->fields = array_merge($this->fields, $fields);
        }
        return $this;
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
     * @return string
     */
    public function toSQL(): string
    {
        $fields = implode(',', $this->fields);
        $sql = "SELECT * FROM {$this->from}";
        if($this->where)
        {
            $sql .= " WHERE " . $this->where;
        }
        if(!empty($this->order))
        {
            $sql .= " ORDER BY " . implode(', ', $this->order);
        }
        if($this->limit > 0)
        {
            $sql .= " LIMIT " . $this->limit;
        }  
        if($this->offset !== null)
        {
            $sql .= " OFFSET " . $this->offset;
        }
        return $sql;
    }
    
    /**
     * 
     * @param string $fields
     * @return string
     */
    public function fetch(string $fields): string
    {
        $query = $this->pdo->prepare($this->toSQL());
        $query->execute($this->params);
        $result = $query->fetch();
        if($result === false)
        {
            return null;
        }
        return $result[$fields] ?? null;
    }
    
    /**
     * 
     * @param \PDO $pdo
     * @return int
     */
    public function count(): int
    {
        $query = clone $this;
        return (int)$query->select('COUNT(id) count')->fetch('count');
    }
    
    /**
     * 
     * @return array
     */
    public function fetchAll(): array
    {
        try 
        {
            $query = $this->ppdo->prepare($this->toSQL());
            $query->execute($this->params);
            return $query->fetchAll();
        }
        catch(\Exception $e)
        {
            throw new \Exception("impossible d\'effectuer la requéte " . $this->toSQL() . " : " . $e->getMessage());
        }
        
    }
    
    public function join()
    {
        
    }
}

//test query builder
//Recherche par ville
//$query = (new QueryBuilder($pdo))->from('products');
//$sortable = ["id", "name", "city", "price", "adress"];
//if(!empty($_GET['q']))
//{
//$query->where('city LIKE :city')
//      ->setParam('city', '%' . $_GET[q] . '%');
//}

//$count = (clone $query)->count();

//Organisation
//if(!empty($_GET['sort']) && in_array($_GET['sort'], $sortable))
//{
//$query->orderBy($_GET['sort'], $_GET['dir'] ?? 'asc');
//}

//Pagination
//$query
//->limit(PER_PAGE)
//->page($_GET['p'] ?? 1);
//$products = $query->fetchAll();
//$table = new Table($query, $_GET);
//$table->sortable('id', 'ville');
//$table->setHeaders([
//'id' => 'ID',
//'name' => 'Nom'
//'city => 'city'
//]);
//$pages = ceil($count / PER_PAGE);

//vue pagination
//<?php if ($pages > 1 && $pages > 1); ? >
//<a href="?<?=URLHelper::withParam($_GET, "p", $page - 1)? >" class="btn btn-primary">
//Page précédente</a>
//<?php endif ? >
//<?php if ($pages > 1 && $page < $pages); ? >
//<a href="?<?=URLHelper::withParam($_GET, "p", $page + 1)? >" class="btn btn-primary">
//Page suivante</a>
//<?php endif ? >
