<?php

namespace blog\session;

/**
 * Description of SessionInterface
 * @author constancelaloux
 */
interface SessionInterface 
{
    /**
    * Get an information in session
    * @param string $key
    * @param $default
    * @return mixed
    */
    public function get(string $key, $default = null);

    /**
    * Add an information in session
    * @param $value
    * @return mixed
    */
    public function set(string $key, $value);

    /**
    * Delete a key in session
    * @param string $key
    */
    public function delete(string $key);
}
