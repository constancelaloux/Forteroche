<?php

namespace blog\session;

/**
 * Manage Flash Messages
 * @author constancelaloux
 */
interface SessionInterface 
{
    /**
    * Récupére une information en session
    * @param string $key
    * @param $default
    * @return mixed
    */
    public function get(string $key, $default = null);

    /**
    * Ajoute une information en session
    * @param $value
    * @return mixed
    */
    public function set(string $key, $value);

    /**
    * Supprime une clef en session
    * @param string $key
    */
    public function delete(string $key);
}
