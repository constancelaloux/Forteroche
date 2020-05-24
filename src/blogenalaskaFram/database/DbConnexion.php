<?php

namespace blog\database;

use PDO;

use blog\DotEnv;
/**
 * Description of DbConnexion
 *
 * @author constancelaloux
 */
class DbConnexion 
{
    protected $db;

    protected function connect()
    {
        //On créé un objet db
        //$db = new \PDO('mysql:host=localhost;dbname=blogalaska;charset=utf8', 'root', 'root');
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
        //return $db; 
        try 
        {
            $dotenv = new DotEnv();
            $dotenv->load(__DIR__.'/../../../.env');
            //print_r($_ENV['DB_USER']);
            $db = new \PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].';charset=utf8',$_ENV['DB_USER'],$_ENV['DB_PASS']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // On émet une alerte à chaque fois qu'une requête a échoué.
            return $db;
        } 
        catch (PDOException $e) 
        {
            echo 'Connection failed: ' . $e->getMessage();
        }

        //SimpleOrm::useConnection($conn, $dbname= $_ENV['DB_NAME']);
    } 
}
