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
        //On vérifie qu'il s'agit bien d'une chaine de caractéres
        if(is_string($surname))
        {
            //L'attribut de l'admin manager sera = a $surname. 
            //Il aura la valeur de la variable $surname
            $this->_surname = $surname;
        }
    }
    
    public function setPassword($password)
    {
        if(is_string($password))
        {
           $this->_password = $password;
        } 
    }
    
    public function setUsername($username)
    {
        if(is_string($username))
        {
            $this->_username = $username;
        }
    }
    
        public function setFirstname($firstname)
    {
        if(is_string($firstname))
        {
            $this->_firstname = $firstname;
        }
    }
    
    
    //Hydratation = assigner des valeurs aux attributs passées en paramétres. 
    //Un tableau de données doit etre passé à la fonction(d'ou le préfixe "array")
    public function hydrate(array $donnees)
    {
     /*   if (isset($donnees['surname']))
        {
            $this->setSurname($donnees['surname']);
        }

            if (isset($donnees['password']))
        {
            $this->setPassword($donnees['password']);
        }

            if (isset($donnees['username']))
        {
            $this->setUsername($donnees['username']);
        }

            if (isset($donnees['firstname']))
        {
            $this->setFirstname($donnees['firstname']);
        }*/
        
        foreach($donnees as $key => $value)
        {
            //On va chercher la fonction du setter (on la reconnait grace à la maj apres le setter).
            //On va donner une valeur à la clé grace à la fonction
            $method = 'set'.ucfirst($key);
            
            //Il faut maintenant vérifier que cette méthode existe. Le this = le nom de la classe. 
            //Si le setter correspondant existe
            if(method_exists($this, $method))
            {
                //On appelle le setter
                //La clé aura bien une valeur et donc notre personnage de la classe représenté par this.
                $this->$method($value);
            }
        }
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
