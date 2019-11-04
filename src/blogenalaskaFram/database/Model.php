<?php

namespace blog\database;

use blog\database\DbConnexion;

use blog\database\Str;

use blog\database\UnitOfWork;
/**
 * Description of newPHPClass
 *
 * @author constancelaloux
 */
class Model extends DbConnexion
{  
       /**
     * Whether the EntityManager is closed or not.
     *
     * @var bool
     */
    private $closed = false;

        /**
     * The UnitOfWork used to coordinate object-level transactions.
     *
     * @var \Doctrine\ORM\UnitOfWork
     */
    private $unitOfWork;

    /**
     * Indicates if the model is new.
     *
     * @var bool
     */

    private $isNew = true;
    
    /**
     * Indicates the class associated with the model.
     *
     * @var bool
     */

    protected $class;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $tableName;
    
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

        /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];
        /**
     * The name of the "created at" column.
     *
     * @var string
     */
    //const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    //const UPDATED_AT = 'updated_at';

        /**
     * The loaded relationships for the model.
     *
     * @var array
     */
    /*protected $relations = [];


    private $propsToImplode = [];
    private $sqlQuery = '';
    protected $key;
    public $method; */
    
    public function __construct()//array $donnees) 
    {
        $this->unitOfWork        = new UnitOfWork($this);
        //Je récupére le nom de la table
    }
    
    /**
     * Get the class name.
     * 
     * @access public
     * @static
     * @return string
     */
    public function getClassName($entity)
    {
        //print_r('je passe dans getClassName');
        //Je récupére le nom de la class auxquel j'ai fait appel dans le controller
        $this->class = new \ReflectionClass($entity);
        //print_r($this->class);
        //$this->class = get_called_class();
        //$reflectionObj = new \ReflectionClass(get_called_class());
        //print_r($this->class);
        return $this->class;
    }
    
    /**
     * Get the table name for this class.
     * 
     * @access public
     * @static
     * @return string
     */
    public function getTableName()
    {
        //Je récupére le nom de la table = nom de la class
        $this->tableName = $this->class->getShortName();
        return $this->tableName;
    }
    
    /**
     * Get our PDO connection.
     */
    public function getConnection()
    {
        //J'instancie la connexion à la base de données
        $this->db = $this->connect();
        return $this->db;
    }
    
    public function persist($entity)
    {
        if ( ! is_object($entity)) {
            throw ORMInvalidArgumentException::invalidObject('EntityManager#persist()' , $entity);
        }

        $this->errorIfClosed();

        $this->unitOfWork->persist($entity);
    }
    
        /**
     * Throws an exception if the EntityManager is closed or currently not active.
     *
     * @return void
     *
     * @throws ORMException If the EntityManager is closed.
     */
    private function errorIfClosed()
    {
        if ($this->closed) {
            throw ORMException::entityManagerClosed();
        }
    }



    /**
    * Save (insert/update) to the database.
    *
    * @access public
    * @return void
    */
    public function save ($entity)
    {
        //print_r($entity);
        //Je récupére le nom de la class
        $this->getClassName($entity);
        //Je récupére le nom de la table associée
        $this->getTableName(); 
        //print_r($methods);
        //print_r($entity->test());
        //exit("je sors");
        //$essai = $this->id;
        //$test = $this->test;
        //$test = $this->_attributes['id'];
        //print_r($test);
        //print_r($essai);
        //die('meurs');
        //print_r($this->class);
        //$test = $data->test();
        //$id = $data->id();
        if ($this->isNew())
        {
            $this->insert();
        }
        else
        {
            $this->update();
        }
    }
    
        /**
     * Check if the current record has just been created in this instance.
     * 
     * @access public
     * @return boolean
     */
    public function isNew ()
    {
        return $this->isNew;
    }
    
    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function insert()
    {
        die("je meurs");
        foreach ($this->_attributes AS $key => $value)
        {
            //$this->getCastType($key);
            $fieldNames[] = sprintf('`%s`', $key);
            $fieldMarkers[] = '?';
            $types[] = $this->parseValueType($value);
            //print_r($types);

            //$values[] = $types;
            $values[] = &$array[$key];
            print_r($this->array);
        }
        $sql = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", self::getTableName(), implode(', ', $fieldNames), implode(', ', $fieldMarkers));
        //$sql = 'INSERT INTO'.' '.$tableName.'('.$setClause.')'.' '.'VALUES'.' '.'('.$setName.')';//'WHERE id ='.$this->id;
        $saveSqlQuery = $this->getConnection()->prepare($sql);
        print_r($saveSqlQuery);
            die("meurs");
        //$saveSqlQuery->bindValue($fieldMarkers, $value, \PDO::PARAM_STR);
        call_user_func_array(array($saveSqlQuery, 'bindParam'), array_merge(array(implode($types)), $values));
        //call_user_func_array(array($saveSqlQuery, 'bind_param'), refValues($values));
        $saveSqlQuery->execute();
        die("meurs");
    }
    

    
    
        /**
     * Parse a value type.
     * 
     * @access private
     * @param mixed $value
     * @return string
     */
    private function parseValueType ($value)
    {
        // ints
        if (is_int($value))
            return 'i';
        // doubles
        if (is_double($value))
            return 'd';
        return 's';
    }
    
        /**
     * Hydrate the object with null values.
     * Fetches column names using DESCRIBE.
     * 
     * @access private
     * @return void
     */
    private function hydrateEmpty ()
    {
        // set our data
        if (isset($this->erLoadData) && is_array($this->erLoadData))
            foreach ($this->erLoadData AS $key => $value)
                $this->{$key} = $value;
        foreach ($this->getColumnNames() AS $field)
            $this->{$field} = null;
        // mark object as new
        $this->isNew = true;
    }
    
            /**
     * Dynamically set attributes on the entity.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    /*public function __set()
    {
        if ($this->hasSetMutator()) {
            $method = 'set'.$this->getMutatorMethod();
            $this->$method($value);
        } else {
            $this->attributes[$key] = $value;
        }
    }*/
    /*public function __set($key, $value)
    {
        print_r($key);
        print_r($value);
        die("meurs");
        $this->setAttribute($key, $value);
    }*/
    
    /**
    * Set a given attribute on the model.
    *
    * @param  string  $key
    * @param  mixed  $value
    * @return $this
    */
    public function setAttribute($key, $value)
    {
                //print_r($key);
                //die("meurs un autre jour");
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) 
        {
            
            $method = 'set'.Str::studly($key).'Attribute';

            return $this->{$method}($value);
        }

        $this->_attributes[$key] = $value;
        return $this;
    }
    
    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasSetMutator()
    {
        //die("meurs un autre jour");
        return method_exists($this, 'set'.Str::studly($key).'Attribute');
    }


    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    /*public function __get($key)
    {
        return $this->getAttribute($key);
    }*/

    
        /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->_attributes[$key];
    }
}
