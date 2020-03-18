<?php

namespace blog\config;

/**
 *
 * @author constancelaloux
 */
interface ContainerInterface 
{
     /**
     * Define an object or a value in the container.
     *
     * @param string $name Entry name
     */
    //public function set($key, callable $resolver);
    
     /**
     * Returns an entry of the container by its name.
     *
     * @param string $name Entry name or a class name.
     */
    public function get($key);
    
     /**
     * Test if the container can provide something for the given name.
     *
     * @param string $name Entry name or a class name.
     */
    public function has($id);
}
