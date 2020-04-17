<?php

namespace blog;

/**
 *
 * @author constancelaloux
 */
trait Hydrator 
{
    public function hydrate($data)
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
    }
}
