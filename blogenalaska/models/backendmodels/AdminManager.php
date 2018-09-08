<?php

namespace Forteroche\blogenalaska\models\backendmodels; // La classe AdminManager sera dans ce namespace

require_once("Manager.php");

class AdminManager extends Manager {
    //attributs
    private $_password;
    private $_username;
    private $_surname;
    private $_firstname;
    
    // Liste des getters. Je pourrais réutiliser les fonctions par la suite
  
    public function password()
    {
      return $this->_password;
    }
    
    public function username()
    {
      return $this->_username;
    }
    
    public function surname()
    {
      return $this->_surname;
    }
    
    public function firstname()
    {
      return $this->_firstname;
    }
    
    //liste des setters
      public function setSurname($surname)
  {
    $surname = $surname;
  }
        public function setPassword($password)
  {
    spassword = $password;
    
  }
          public function setUsername($username)
  {
    susername = $username;
    
  }
    public function sendDatasBlogAdmin()
    {
        $bdd = $this->dbConnect();
        
        $passFromUser ="jean38"; // password
        $password = password_hash($passFromUser, PASSWORD_DEFAULT);
        $username = "Jean_Forteroche";
        $surname = "Forteroche";
        $firstname = "Jean";
        
        $sendAdminDatas = $bdd->prepare('INSERT INTO articles_author (surname, firstname, username, password)'
                . '                      VALUES(:surname, :firstname, :username, :password)');
        $sendAdminDatas->bindValue(':surname', $surname);
        $sendAdminDatas->bindValue(':firstname', $firstname);
        $sendAdminDatas->bindValue(':username', $username);
        $sendAdminDatas->bindValue(':password', $password);


        $sendAdminDatas->execute();
        echo $password . "admin user had been created";
        return $sendAdminDatas;
    }
    
    /**
     * On récupére les données en bdd
     * @param type $usernamevar
     * @return type
     */
    public function getDataLog($usernamevar)
    {
        $bdd = $this->dbConnect();

        $get = $bdd->prepare('SELECT password FROM articles_author WHERE username = :username');
        $get->bindValue(':username', $usernamevar);
        $get->execute();
        $donnees = $get->fetch();

        return $donnees; 
    }
    

}
