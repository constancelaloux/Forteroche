<?php

namespace blog;

use blog\RequestInterface;
//use blogenalaska\Lib\BlogenalaskaFram\ApplicationComponent;

/**
* Description of HTTPRequest
* La requéte du client.
* @author constancelaloux
*/

class HTTPRequest implements RequestInterface
{
    /**
    * @return array
    * Obtenir un cookie.
    */
    public function cookieData($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
    }

    /**
    * @return array
    * Permet de vérifier si la variable cookie existe
    */
    public function cookieExists($key)
    {
        return isset($_COOKIE[$key]);
    }

    /**
    * @return array
    * Obtenir une variable GET.
    */
    public function getData($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    /**
    * @return array
    * Verifier si il y a une variable get qui existe.
    */
    public function getExists($key)
    {
        return isset($_GET[$key]);
    }

    /**
    * @return array
    * Obtenir la méthode employée pour envoyer la requête (méthode GET ou POST).
    */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
    * @return array
    * Obtenir une variable POST.
    */
    public function postData($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
    /*public function postData($datas)
    {
      return isset($_POST[$datas]) ? $_POST[$datas] : null;
    }*/

    /**
    * @return array
    * Verifier si il y a une variable post qui existe.
    */
    public function postExists($key)
    {
        return isset($_POST[$key]);
    }

    /**
    * @return string
    * Obtenir l'URL entrée (utile pour que le routeur connaisse la page souhaitée).
    */
    public function requestURI()
    {
        //print_r($_SERVER['REQUEST_URI']);
        return $_SERVER['REQUEST_URI'];
    }
        
        
    /**
    * @return array
    * retourne la variable de session.
    */
    public function getSession()
    {
        return $_SESSION[$key];
    }
    
    /**
    * @return array
    * Verifier si il y a une session qui existe.
    */
    public function sessionExists($key)
    {
        return isset($_SESSION[$key]);
    }
}
