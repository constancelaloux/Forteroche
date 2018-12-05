<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//namespace Forteroche\blogenalaska\Models\BackendModels; 

class ArticlesManager
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

        public function add(Article $articles)
            {
                $sendArticlesDatas = $this->_db->prepare('INSERT INTO articles (content, subject, create_date) '
                        . 'VALUES(:content, :subject, NOW())');

                $sendArticlesDatas->bindValue(':content', $articles->content(), \PDO::PARAM_STR);
                $sendArticlesDatas->bindValue(':subject', $articles->subject(), \PDO::PARAM_STR);
               // $sendArticlesDatas->bindValue('NOW()', $articles->createdate(), \PDO::PARAM_STR);
                //print_r($sendArticlesDatas->bindValue(':content', $articles->content(), \PDO::PARAM_STR));
                //print_r($sendArticlesDatas->bindValue(':subject', $articles->subject(), \PDO::PARAM_STR));

                $sendArticlesDatas->execute();
                print_r("fini j'ai inséré les données");
            }

        public function delete(Article $articles)
            {
                //Execeute une requéte de type delete.
            }

        public function verify(Article $articles)
            {

                //execute une requéte de type select avec une clause Where, et retourne un objet AdminManager. 

                $getArticlesDatas = $this->_db->prepare("SELECT content, subject, create_date FROM articles WHERE content = :content");
                $getArticlesDatas->bindValue(':content', $articles->content(), \PDO::PARAM_STR );
                $getArticlesDatas->execute();
                print_r("je recupere mes donnees");

                return new Author($getAuthorLogin->fetch(\PDO::FETCH_ASSOC));
            }

        public function getList()
            {
                //retourne la liste de tous les Articles
            }

        public function update(Article $articles)
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
