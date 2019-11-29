<?php

namespace blog\config;
use blog\config\ContainerInterface;
/**
 * Description of Container
 *
 * @author constancelaloux
 */
class Container  implements ContainerInterface
{
    protected $instances = [];
    
    public function __construct($configFolder)
    {
 
    }
    
    public function get($dependency)
    {
        if (!$this->has($dependency)) 
        {
            //throw new DependencyNotRegisteredException($dependency); //DependencyNotRegisteredException implements NotFoundExceptionInterface
        }
        $entry = $this->instances[$dependency];
        //other necessary code here
        //return $this->concreteInstance($entry);
    }
    
    public function has($dependency)
    {
        return isset($this->instances[$dependency]);
    }
}

