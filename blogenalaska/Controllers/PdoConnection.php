<?php
namespace Forteroche\blogenalaska\Controllers;
//namespace Forteroche\blogenalaska\models\backendModels;
//require 'controllers/backendcontrollers/FormAuthorAccessControler.php';

use PDO;
//require("AuthorManager.php");

class PdoConnection
{
    public static function connect()
    {
         //On créé un objet db
        
        $db = new \PDO('mysql:host=localhost;dbname=blogalaska;charset=utf8', 'root', 'root');
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
        print_r("ma connexion est ok");
        return $db; 
    }  
}

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once("models/backendModels/AuthorManager.php");
//require_once("models/backendModels/Author.php");
//controllers/backendcontrollers/FormAuthorAccessControler.php');
//$author = new Author();
/**
 * Description of newPHPClass
 *
 * @author constancelaloux
 */
//Connexion à la base de données et création des identifiants de Jean Forteroche
   /* $author = new Author([
        'passFromUser' =>'jean38', // password
        //'password' =>crypt('laloux38'),
        'password' => password_hash('passFromUser', PASSWORD_DEFAULT),
        'username' =>'Jean_Forteroche',
        'surname' => 'Forteroche',
        'firstname' => 'Jean'
    ]); *
  /*  try
    {*/


       // echo '<br>'; // permet un retour à la ligne
        //$test = new FormAuthorAccessControler();
        //$testbis = transferDatatoModel($test);
        //$manager = new AuthorManager($db);


       // $manager->add($author);
        //$manager->get($authormanager);
        
  /*  }
    catch(PDOException $e)
    {
        die('Erreur : '.$e->getMessage());
    }*/

        
/*class PDO {
    //put your code here
    public static function getMysqlConnexionWithPDO()
    {
        try
        {
            $db = new \PDO('mysql:host=localhost;dbname=blogalaska;charset=utf8','root','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $db; 
        }

        catch(PDOException $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}*/
