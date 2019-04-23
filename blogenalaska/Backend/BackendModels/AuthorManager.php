<?php

//namespace Forteroche\blogenalaska\Models\BackendModels; 

/**
 * Description of Manager
 *
 * @author constancelaloux
 */
//require_once 'Manager.php';

class AuthorManager// extends Manager
    {


        //Cette gestion sera le rôle d'une autre classe, communément appelée manager. Dans notre cas, notre gestionnaire de personnage sera tout simplement nomméePersonnagesManager.
        private $_db; //instance de PDO

        //  n'oubliez pas d'ajouter un setter pour notre manager afin de pouvoir modifier l'attribut$_db. 
        //La création d'un constructeur sera aussi indispensable si nous voulons assigner à cet attribut un objet PDO dès l'instanciation du manager.
        //Initialisation de la connection a la base de données
        public function __construct($db)
            { 
                $this->setDb($db);      
            }

        public function add(Author $author)
            {
                //Preparation de la requéte d'insertion.
                //Assignation des valeurs pour le password, surname, username et firstname.
                //Execution de la requéte`
                // Préparation de la requête d'insertion.
                $sendAdminDatas = $this->_db->prepare('INSERT INTO articles_author (surname, firstname, username, password) '
                        . 'VALUES(:surname, :firstname, :username, :password)');
                $sendAdminDatas->bindValue(':surname', $author->surname(), \PDO::PARAM_STR);
                $sendAdminDatas->bindValue(':firstname', $author->firstname(), \PDO::PARAM_STR);
                $sendAdminDatas->bindValue(':username', $author->username(), \PDO::PARAM_STR );
                $sendAdminDatas->bindValue(':password', $author->password(), \PDO::PARAM_STR);
                // Exécution de la requête.
                $sendAdminDatas->execute();    
            }

        public function delete(Author $author)
            {
                //Execeute une requéte de type delete.
            }

        public function verify(Author $author)
            {
                //execute une requéte de type select avec une clause Where, et retourne un objet AdminManager. 
                $getAuthorLogin = $this->_db->prepare("SELECT password, username FROM articles_author WHERE username = :username");//AND password = :password");
                $getAuthorLogin->bindValue(':username', $author->username(), \PDO::PARAM_STR );
                //$getAuthorLogin->bindValue(':password', $author->password(), \PDO::PARAM_STR );
                $getAuthorLogin->execute();

                return new Author($getAuthorLogin->fetch(\PDO::FETCH_ASSOC));
            }

        public function getList()
            {
                //retourne la liste de tous les AdminManager
            }

        public function update(Author $author)
            {
                // Prépare une requête de type UPDATE.
                // Assignation des valeurs à la requête.
                // Exécution de la requête.
            }

       public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
    }
    
