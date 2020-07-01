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
        try 
        {
            $dotenv = new DotEnv();
            $dotenv->load(__DIR__.'/../../../.env');
            $db = new \PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'].';charset=utf8',$_ENV['DB_USER'],$_ENV['DB_PASS']);
            /**
             * On émet une alerte à chaque fois qu'une requête a échoué.
             */
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } 
        catch (PDOException $e) 
        {
            echo 'Connection failed: ' . $e->getMessage();
        }
    } 
}
