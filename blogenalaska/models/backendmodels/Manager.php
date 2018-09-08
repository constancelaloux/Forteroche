<?php

namespace Forteroche\blogenalaska\models\backendmodels;

/**
 * Description of Manager
 *
 * @author constancelaloux
 */
class Manager {

       protected function dbConnect()
    {
        try
        {
            $bdd = new \PDO('mysql:host=localhost;dbname=blogalaska;charset=utf8','root','root');
            return $bdd; 
        }

        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}
