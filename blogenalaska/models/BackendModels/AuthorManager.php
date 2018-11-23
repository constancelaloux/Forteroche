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
        //Execution de la requéte`
        $sendAdminDatas = $db->prepare('INSERT INTO articles_author (surname, firstname, username, password)'
                          . 'VALUES(:surname, :firstname, :username, :password)');
        $sendAdminDatas->bindValue(':surname', $admin->surname());
        $sendAdminDatas->bindValue(':firstname', $admin->firstname());
        $sendAdminDatas->bindValue(':username', $admin->username());
        $sendAdminDatas->bindValue(':password', $admin->password());
        $sendAdminDatas->execute();
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
        //$admin = [];
        $get = $this->$db->prepare('SELECT password FROM articles_author WHERE username = :username');
        $get->bindValue(':username', $usernamevar);
        $get->execute();
        $donnees = $get->fetch();

        return $donnees; 
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
