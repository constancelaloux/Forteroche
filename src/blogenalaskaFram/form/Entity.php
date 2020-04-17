<?php

namespace blog\form;

/**
 * Description of Entity
 *
 * @author constancelaloux
 */
class Entity  implements \ArrayAccess
{
  // Utilisation du trait Hydrator pour que nos entités puissent être hydratées
    use \blog\Hydrator;
  
  // La méthode hydrate() n'est ainsi plus implémentée dans notre classe
    protected $erreurs = [],
            $id;
 
    public function __construct(array $donnees = [])
    {
        if (!empty($donnees))
        {
            $this->hydrate($donnees);
        }
    }
    
     /*public function hydrate($data)
    {
        //print_r($data);
        foreach ($data as $key => $value)
        {
            //print_r($key);
            //print_r($value);
            $method = 'set'.ucfirst($key);
            //print_r($method);
            if (is_callable([$this, $method]))
            {
               // print_r($value);
                //print_r($value);
                //print_r($this->$method($value));
                //print_r($this->$method());//$value))
                $this->$method($value);

                //print_r($method);
                //print_r($value);
                //print_r($this->$method($value));
                //$this->$method($value);
                //print_r($this->$method($value));
            }
        }
    }*/
 
    public function isNew()
    {
        return empty($this->id);
    }
 
    public function erreurs()
    {
        return $this->erreurs;
    }
 
    public function id()
    {
        return $this->id;
    }
 
    public function setId($id)
    {
        $this->id = (int) $id;
    }
 
    public function offsetGet($var)
    {
        if (isset($this->$var) && is_callable([$this, $var]))
        {
            return $this->$var();
        }
    }
 
    public function offsetSet($var, $value)
    {
        $method = 'set'.ucfirst($var);

        if (isset($this->$var) && is_callable([$this, $method]))
        {
            $this->$method($value);
        }
    }
 
    public function offsetExists($var)
    {
        return isset($this->$var) && is_callable([$this, $var]);
    }

    public function offsetUnset($var)
    {
        throw new \Exception('Impossible de supprimer une quelconque valeur');
    }
}
