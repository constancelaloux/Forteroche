<?php
//namespace Forteroche\blogenalaska\Backend\BackendModels;

/**
 * Description of Manager
 *
 * @author constancelaloux
 */
//require_once 'Manager.php';

class AuthorManager
    {


        //Cette gestion sera le rôle d'une autre classe, communément appelée manager. Dans notre cas, notre gestionnaire de personnage sera tout simplement nomméePersonnagesManager.
        private $_db; //instance de PDO

        //n'oubliez pas d'ajouter un setter pour notre manager afin de pouvoir modifier l'attribut$_db. 
        //La création d'un constructeur sera aussi indispensable si nous voulons assigner à cet attribut un objet PDO dès l'instanciation du manager.
        //Initialisation de la connection a la base de données
        public function __construct($db)
            { 
                $this->setDb($db);      
            }
        
        //requéte qui ajoute un administrateur en base de données
        public function add(Author $author)
            {
                try 
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
                catch(PDOException $e)
                    {
                        throw new Exception('la requéte n\'a pas pu etre effectuée'). $e->getMessage();
                    }
            }
        
        //Supprimer un administrateur de la base de données
        public function delete(Author $author)
            {
                //Execeute une requéte de type delete.
            }
            
        //Requéte qui permer de récupérer en base de données le mot de passe et l'identifiant de l'administrateur
        /*public function verify($author)
            {
                try 
                    {
                        //execute une requéte de type select avec une clause Where, et retourne un objet AdminManager. 
                        $checkAuthorLogin = $this->_db->prepare("SELECT  COUNT(*) FROM articles_author WHERE username = :username");//AND password = :password");
                        //$getAuthorLogin->bindValue(':username', $author->username(), \PDO::PARAM_STR );
                        $checkAuthorLogin->execute([':username' => $author]);
                        
                        //$getAuthorLogin->execute();
                        return (bool) $checkAuthorLogin->fetchColumn();
                        //return new Author($getAuthorLogin->fetch(\PDO::FETCH_ASSOC));
                    }
                catch(PDOException $e)
                    {
                        throw new Exception('la requéte n\'a pas pu etre effectuée'). $e->getMessage();
                    }
            }*/
        public function get($author)
            {
                $getAuthorLogin = $this->_db->prepare('SELECT password, username FROM articles_author WHERE username = :username');
                $getAuthorLogin->execute([':username' => $author]);
                //$getAuthorLogin->bindValue(':username', $author->username(), \PDO::PARAM_STR );
                //$getAuthorLogin->closeCursor();
                return new Author($getAuthorLogin->fetch(PDO::FETCH_ASSOC));
            }
        
        //Je vais chercher la liste de tous les admin en base de données
        public function exists($author)
            {
                //on regarde le nombre de lignes en base de données ou nous avons un username portant le meme username que la personne a inséré
                $getAuthorLogin = $this->_db->prepare("SELECT COUNT(*) FROM articles_author WHERE username = :username");

                $getAuthorLogin->execute([':username' => $author]);
                //$getAuthorLogin->closeCursor();
                return (bool) $getAuthorLogin->fetchColumn();
            }

        //Je met à jour un administrateur en base de données
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
    
