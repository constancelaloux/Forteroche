<?php

namespace blog\session;

use blog\session\SessionInterface;
/**
 * Description of PHPSession
 *
 * @author constancelaloux
 */
class PHPSession implements SessionInterface
{ 
    /**
    * Assure que la session est démarrée
    */
    private function ensureSarted()
    {
        if(session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }
    
   /**
    * Récupére une information en session
    * @param string $key
    * @param $default
    * @return mixed
    */
    public function get(string $key, $default = null)
    {
        print_r($key);
        $this->ensureSarted();
        if(array_key_exists($key, $_SESSION))
        {
            return $_SESSION[$key];
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
        $this->ensureSarted();
        $_SESSION[$key] = $value;
        //print_r($_SESSION[$key]);
    }

    /**
    * Supprime une clef en session
    * @param string $key
    */
    public function delete(string $key)
    {
        $this->ensureSarted();
        unset($_SESSION[$key]);
    }
}
