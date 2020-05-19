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
     * Vérifie/Assure que la session est démarrée
     * Ca ne chargera la session que lorsque l'on en aura besoin
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
     * @param type $default
     * @return type
     */
    public function get(string $key, $default = null)
    {
        $this->ensureSarted();
        if(array_key_exists($key, $_SESSION))
        {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Ajoute une information en session
     * @param string $key
     * @param type $value
     */
    public function set(string $key, $value)
    {
        $this->ensureSarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Supprime une clef en session
     * @param string $key
     */
    public function delete(string $key)
    {
        $this->ensureSarted();
        unset($_SESSION[$key]);
        //session_destroy();
    }
}
