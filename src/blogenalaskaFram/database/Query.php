<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\database;

use PDO;

/**
 * Description of Query
 *
 * @author constancelaloux
 */
class Query
{
    private $select;
    
    private $from;
    
    private $where = [];
    
    private $group;
    
    private $order;
    
    private $limit;
    
    private $joins;
    
    private $pdo;
    
    private $params;
    
    public function __construct(\PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * 
     * @param string $table
     * @param string $alias
     * @return \self
     */
    public function from(string $table, string $alias = null): self
    {
        if($alias)
        {
            $this->from[$alias] = $table;
        }
        else
        {
            $this->from[] = $table;
        }
        return $this;
    }
    
    /**
     * 
     * @param string[] ...$fields
     * @return Query
     */
    public function select(string ...$fields): self
    {
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
     * Spécifie l'odre de récupération
     * @param array $order
     * @return Query
     */
    public function order(string $order): self
    {
        $this->order[] = $order;
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
     * @param string[] ...$condition
     * @return Query
     */
    public function where(string ...$condition): self
    {
        $this->where = array_merge($this->where, $condition);
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
     * @param array $params
     * @return \self
     */
    public function params(array $params):self
    {
        $this->params = $params;
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
     * @return type
     */
    public function __toString() 
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
    
    /**
     * 
     * @return type
     */
    private function execute()
    {
        $query = $this->__toString();
        if($this->params)
        {
            $statement = $this->pdo->prepare($query);
            $statement->execute($this->params);
            return $statement;
        }
        return $this->pdo->query($query);
    }
}
