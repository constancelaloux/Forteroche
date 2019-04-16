<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ClientManager// extends Manager
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

        public function add(Client $client)
            {
                //Preparation de la requéte d'insertion.
                //Assignation des valeurs pour le password, surname, username et firstname.
                //Execution de la requéte`
                // Préparation de la requête d'insertion.
                $sendClientDatas = $this->_db->prepare('INSERT INTO comments_author (surname, firstname, username, password) '
                        . 'VALUES(:surname, :firstname, :username, :password)');
                //$sendAdminDatas = $this->_db->prepare('INSERT INTO articles_author (username, password) '
                //        . 'VALUES(:username, :password)');
                // Assignation des valeurs pour le nom du personnage.
                $sendClientDatas->bindValue(':surname', $client->surname(), \PDO::PARAM_STR);
                $sendClientDatas->bindValue(':firstname', $client->firstname(), \PDO::PARAM_STR);
                $sendClientDatas->bindValue(':username', $client->username(), \PDO::PARAM_STR );
                $sendClientDatas->bindValue(':password', $client->password(), \PDO::PARAM_STR);
                // Exécution de la requête.
                $sendClientDatas->execute();    
            }

        public function delete(Client $client)
            {
                //Execeute une requéte de type delete.
            }

        public function verify(Client $client)
            {
                //execute une requéte de type select avec une clause Where, et retourne un objet AdminManager. 
                $getClientLogin = $this->_db->prepare("SELECT password, username FROM comments_author WHERE username = :username");//AND password = :password");
                $getClientLogin->bindValue(':username', $client->username(), \PDO::PARAM_STR );
                //$getAuthorLogin->bindValue(':password', $author->password(), \PDO::PARAM_STR );
                $getClientLogin->execute();
                //print_r($getAuthorLogin->fetch(\PDO::FETCH_ASSOC));
                //exit();
                return new Client($getClientLogin->fetch(\PDO::FETCH_ASSOC));
            }

        public function getList()
            {
                //retourne la liste de tous les AdminManager
            }

        public function update(Client $client)
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