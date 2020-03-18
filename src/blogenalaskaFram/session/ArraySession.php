<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\session;
use blog\session\SessionInterface;

/**
 * Description of ArraySession
 *
 * @author constancelaloux
 */
class ArraySession implements SessionInterface
{
    private $session = [];

   /**
    * Récupére une information en session
    * @param string $key
    * @param $default
    * @return mixed
    */
    public function get(string $key, $default = null)
    {
        if(array_key_exists($key, $this->session))
        {
            return $this->session[$key];
        }
        return $default;
    }

    /**
    * Ajoute une information en session
    * @param $value
    * @return mixed
    */
    public function set(string $key, $value)
    {
        //print_r($key);
        //print_r($value);
        $this->session[$key] = $value;
    }

    /**
    * Supprime une clef en session
    * @param string $key
    */
    public function delete(string $key)
    {
        //print_r($this->session[$key]);
        unset($this->session[$key]);
        //print_r($this->session[$key]);
    } 
}
