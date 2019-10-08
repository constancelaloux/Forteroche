<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog;

/**
 * Description of DbConnexion
 *
 * @author constancelaloux
 */
class DbConnexion 
{
    protected function connect()
        {
            //On créé un objet db
            $db = new \PDO('mysql:host=localhost;dbname=blogalaska;charset=utf8', 'root', 'root');
            //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
            return $db; 
        } 
}
