<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog;

/**
 *
 * @author constancelaloux
 */
interface RequestInterface 
{
    /**
    * @return string
    * Obtenir l'URL entrée (utile pour que le routeur connaisse la page souhaitée).
    */
    public function requestURI();
    
    /**
    * @return array
    * Obtenir un cookie.
    */
    public function cookieData($key);

    /**
    * @return array
    * Permet de vérifier si la variable cookie existe
    */
    public function cookieExists($key);
    
    /**
    * @return array
    * Obtenir une variable GET.
    */
    public function getData($key);
       
    /**
    * @return array
    * Verifier si il y a une variable get qui existe.
    */
    public function getExists($key);
    
    /**
    * @return array
    * Obtenir la méthode employée pour envoyer la requête (méthode GET ou POST).
    */
    public function method();
    
    /**
    * @return array
    * Obtenir une variable POST.
    */
    public function postData($key);
    
    /**
    * @return array
    * Verifier si il y a une variable post qui existe.
    */
    public function postExists($key);
    
    
    /**
    * @return array
    * retourne la variable de session.
    */
    public function getSession();
    
    /**
    * @return array
    * Verifier si il y a une session qui existe.
    */
    public function sessionExists($key);
}
