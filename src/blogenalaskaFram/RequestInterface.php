<?php

namespace blog;

/**
 *Description of RequestInterface
 * @author constancelaloux
 */
interface RequestInterface 
{
    /**
     * Get the URL entered (useful for the router to know the desired page)
     */
    public function requestURI();

    /**
     * Obtain a cookie.
     * @param type $key
     */
    public function cookieData($key);

    /**
     * Check if the cookie variable exists
     * @param type $key
     */
    public function cookieExists($key);

    /**
     * Get a get variable
     * @param type $key
     */
    public function getData($key);
    //public function getData();
       
    /**
     * Check if there is a get variable that exists.
     * @param type $key
     */
    public function getExists($key);

    /**
     * Obtain the method used to send the request (GET or POST method).
     */
    public function method();

    /**
     * Get a POST variabl
     * @param type $key
     */
    public function postData($key);
    //public function postData();

    /**
     * Check if there is a post variable that exists.
     * @param type $key
     */
    public function postExists($key);
    
    /**
     * returns the session variable.
     */
    public function getSession();

    /**
     * Check if there is a session that exists.
     * @param type $key
     */
    public function sessionExists($key);
}
