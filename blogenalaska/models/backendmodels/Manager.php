<?php

namespace Forteroche\blogenalaska\models\backendmodels;

/**
 * Description of Manager
 *
 * @author constancelaloux
 */
class Manager 
{
    private $_db; //instance de PDO
    
    public function _construct($db)
    {
        $this->setDb($db);
    }
    
    public function add(AdminManager $admin)
    {
        //Preparation de la requéte d'insertion.
        //Assignation des valeurs pour le password, surname, username et firstname.
        //Execution de la requéte
    }
    
        public function delete(AdminManager $admin)
    {
        //Execeute une requéte de type delete.
    }
    
    public function get($id)
    {
       //execute une requéte de type select avec une clause Where, et retourne un objet AdminManager. 
    }
    
        public function getList()
    {
        //retourne la liste de tous les AdminManager
    }
    
    public function update(AdminManager $admin)
    {
            // Prépare une requête de type UPDATE.
    // Assignation des valeurs à la requête.
    // Exécution de la requête.
    }
    
    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
    
    /*

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
    }*/
}
