<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CommentsManager
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
        
        //J'ajoute un article en bdd
        public function add(Comment $comment)
            {
                $sendCommentDatas = $this->_db->prepare('INSERT INTO comments (content, id_From_Article, create_date) '
                        . 'VALUES(:content, :idFromArticle, NOW())');

                $sendCommentDatas->bindValue(':content', $comment->content(), \PDO::PARAM_STR);
                $sendCommentDatas->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_STR);
                //$sendArticlesDatas->bindValue('NOW()', $articles->createdate(), \PDO::PARAM_STR);
                //print_r($sendArticlesDatas->bindValue(':content', $articles->content(), \PDO::PARAM_STR));
                //print_r($sendArticlesDatas->bindValue(':subject', $articles->subject(), \PDO::PARAM_STR));

                $sendCommentDatas->execute();
            }
            
        //Je compte les commentaires en bases de données
        public function count()
            {
                return $this->_db->query('SELECT COUNT(*) as nbCmt FROM comments')->fetchColumn();
            }
            
            
        //Je récupére 5 commentaires
        public function getListOfFiveComments($page,$nbrCommentsPerPage)
            {
                $getComments = $this->_db->prepare("SELECT * FROM comments ORDER BY ID DESC LIMIT ".(($page-1)*$$nbrCommentsPerPage).", $nbrCommentsPerPage "); 
                $getComments->execute(); 
                while ($donnees = $getComments->fetch())
                    {
                        $comment =  new Comment($donnees);
                        $commentDate = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        $comment->setCreatedate($commentDate);
                        $data[] = $comment;
                    }

                return $data;
            }
            
        public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
    }
