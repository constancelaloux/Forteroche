<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blogenalaska\Lib\BlogenalaskaFram;
//use blogenalaska\Lib\BlogenalaskaFram\ApplicationComponent;
/**
 * Description of HTTPRequest
 *
 * @author constancelaloux
 */
//La requéte du client
class HTTPRequest extends ApplicationComponent
    {
//Obtenir un cookie.
        public function cookieData($key)
            {
              return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
            }

        public function cookieExists($key)
            {
              return isset($_COOKIE[$key]);
            }
            
//Obtenir une variable GET.
        public function getData($key)
            {
              return isset($_GET[$key]) ? $_GET[$key] : null;
            }

        public function getExists($key)
            {
              return isset($_GET[$key]);
            }
            
//Obtenir la méthode employée pour envoyer la requête (méthode GET ou POST).
        public function method()
            {
              return $_SERVER['REQUEST_METHOD'];
            }
            
//Obtenir une variable POST
        public function postData($key)
            {
              return isset($_POST[$key]) ? $_POST[$key] : null;
            }

        public function postExists($key)
            {
              return isset($_POST[$key]);
            }
            
//Obtenir l'URL entrée (utile pour que le routeur connaisse la page souhaitée).
        public function requestURI()
            {
                //print_r($_SERVER['REQUEST_URI']);
                return $_SERVER['REQUEST_URI'];
            }
    }
