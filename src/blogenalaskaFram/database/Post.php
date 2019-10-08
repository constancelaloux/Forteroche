<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\database;

use blog\database\Entity;

use PDO;

use blog\DotEnv;
/**
 * Description of Post
 *
 * @author constancelaloux
 */
class Post extends Entity
{
    protected $tableName = 'Posts'; // usually tables are named in plural when the object should be named singular

    public $id;

    public $title;

    public $body;

    public $author_id;

    public $date;

    public $views;

    public $finished;
    
    protected $db;
    
    public function __construct() 
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/.env');
        //On créé un objet db
        //$this->db = new \PDO('mysql:host=localhost;dbname=blogalaska;charset=utf8', 'root', 'root');
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
        //return $this->db; 
    }
    
    public function save() 
    { // this methods save obejct to databases table
        $class = new \ReflectionClass($this);
        //$tableName = strtolower($class->getShortName());
        $tableName = $class->getShortName();

        $propsToImplode = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) 
        { // consider only public properties of the providen 
            $propertyName = $property->getName();
            //print_r($propertyName);
            //print_r($this->{$propertyName});
            $propsToImplode[] = $propertyName;
            //$propsToImplode[] = ''.$propertyName.' = "'.$this->{$propertyName}.'"';
            $name[] = '"'.$this->{$propertyName}.'"';
            //print_r($name);
            //print_r($propsToImplode);
        }

        $setClause = implode(',',$propsToImplode); // glue all key value pairs together
        $setName =  implode(',',$name);
        $sqlQuery = '';

        if ($this->id > 0) 
        {
            $sqlQuery = 'UPDATE `'.$tableName.'` SET '.$setClause.' WHERE id = '.$this->id;
        } 
        else 
        {
            $sqlQuery = 'INSERT INTO'.' '.$tableName.'('.$setClause.')'.' '.'VALUES'.'('.$setName.')';//'WHERE id ='.$this->id;
            //print_r($sqlQuery);
            //INSERT INTO Post(id,title,body,author_id,date,views,finished) VALUES('0','How to cook new pizza','niet','1','1570279652','rien','no')
            //die("merde fait chier");
            //INSERT INTO Post VALUES(id = '3', title = 'How to cook new pizza', body = 'niet', author_id = '1', date = '1570277270', views = 'rien', finished = '')
            //INSERT INTO Post VALUES ('id' = '0', title = 'How to cook pizza', body = 'niet', author_id = '1', date = '1570269449', views = 'rien', finished = '1')
            //INSERT INTO Post VALUES(id ="", title ="How to cook new pizza", body ="niet", author_id ="1", date ="1570271320", views ="rien", finished =""
            //die("merde ca m enerve ce truc de query qui marche pas pitain de bordel de merde");
        }

        $result = $this->db->exec($sqlQuery);

        //die("meurs un autre jour je fais ma db");
        if ($this->db->errorCode()) 
        {
            throw new \Exception($this->db->errorInfo()[2]);
        }
        else
        {
            print_r('ya pas de else');
        }

        return $result;
    }
    
    /**
    *
    * @return Entity[]
    */
    public static function find ($options = []) 
    {

        $result = [];
        $query = '';

        $whereClause = '';
        $whereConditions = [];

        if (!empty($options)) 
        {
            foreach ($options as $key => $value) 
            {
                $whereConditions[] = '`'.$key.'` = "'.$value.'"';
            }
            $whereClause = " WHERE ".implode(' AND ',$whereConditions);
        }

        $raw = self::$db->query($query);

        if (self::$db->errorCode()) 
        {
            throw new \Exception(self::$db->errorInfo()[2]);
        }

        foreach ($raw as $rawRow) 
        {
            $result[] = self::morph($rawRow);
        }

        return $result;
    }
}
