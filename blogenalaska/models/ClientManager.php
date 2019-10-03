<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendModels;
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

//AJOUTER UN CLIENT EN BDD
        public function add(Client $client)
            {
                //Preparation de la requéte d'insertion.
                //Assignation des valeurs pour le password, surname, username et firstname.
                //Execution de la requéte`
                // Préparation de la requête d'insertion.
                $sendClientDatas = $this->_db->prepare('INSERT INTO comments_author (surname, firstname, username, password, imageComment) '
                        . 'VALUES(:surname, :firstname, :username, :password, :imageComment)');
                // Assignation des valeurs pour le nom du personnage.
                $sendClientDatas->bindValue(':surname', $client->surname(), \PDO::PARAM_STR);
                $sendClientDatas->bindValue(':firstname', $client->firstname(), \PDO::PARAM_STR);
                $sendClientDatas->bindValue(':username', $client->username(), \PDO::PARAM_STR );
                $sendClientDatas->bindValue(':password', $client->password(), \PDO::PARAM_STR);
                $sendClientDatas->bindValue(':imageComment', $client->imageComment(), \PDO::PARAM_STR);
                // Exécution de la requête.
                $sendClientDatas->execute();    
            }
//FIN AJOUTER UN CLIENT
            
            
            
//SUPPRIMER UN CLIENT
        public function delete(Client $client)
            {
                //Execeute une requéte de type delete.
                $this->_db->exec('DELETE firstname, surname, password, imageComment FROM comments_author WHERE id = '.$client->id());
            }
//FIN SUPPRIMER UN CLIENT
            
            
            
//ON VERIFIE SI LE MOT DE PASSE ET L UTILISATEUR SONT BIEN EN BDD
            public function get($client)
                {
                    //execute une requéte de type select avec une clause Where, et retourne un objet AdminManager. 
                    $getClientLogin = $this->_db->prepare("SELECT * FROM comments_author WHERE username = :username");//AND password = :password");
                    //$getClientLogin->bindValue(':username', $client->username(), \PDO::PARAM_STR );
                    $getClientLogin->execute([':username' => $client]);
                    //$getClientLogin->execute();

                    return new Client($getClientLogin->fetch(\PDO::FETCH_ASSOC));
                }
                
            public function exists($newClient)
                {
                    //on regarde le nombre de lignes en base de données ou nous avons un username portant le meme username que la personne a inséré
                    $getClientLogin = $this->_db->prepare("SELECT COUNT(*) FROM comments_author WHERE username = :username");

                    $getClientLogin->execute([':username' => $newClient]);

                    return (bool) $getClientLogin->fetchColumn();
                }
//FIN VERIFIE  SI LE MOT DE PASSE ET L UTILISATEUR SONT BIEN EN BDD
      
//METTRE A JOUR UN CLIENT        
        public function update(Client $client)
            {
                // Prépare une requête de type UPDATE.
                // Assignation des valeurs à la requête.
                // Exécution de la requête.
                $dbRequestUpdateClient = $this->_db->prepare('UPDATE comments_author SET password = :password WHERE id = :id');
                $dbRequestUpdateClient->bindValue(':password', $client->password(), \PDO::PARAM_INT);
                $dbRequestUpdateClient->bindValue(':id', $client->id(), \PDO::PARAM_INT);
                $dbRequestUpdateClient->execute();
            }
//FIN METTRE A JOUR UN CLIENT
                     
        
            
        public function getList()
            {
                //retourne la liste de tous les AdminManager
            }

            
                
       public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
    }