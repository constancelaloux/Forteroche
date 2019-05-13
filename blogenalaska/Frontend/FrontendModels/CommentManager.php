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
                $sendCommentDatas = $this->_db->prepare('INSERT INTO comments (content, id_From_Article, create_date, id_comments_author) '
                        . 'VALUES(:content, :idFromArticle, NOW(), :id_comments_author)');
                //$sendCommentDatas->bindValue(':title', $comment->title(), \PDO::PARAM_STR);
                $sendCommentDatas->bindValue(':content', $comment->content(), \PDO::PARAM_STR);
                $sendCommentDatas->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_STR);
                $sendCommentDatas->bindValue(':id_comments_author', $comment->id_comments_author(), \PDO::PARAM_STR);
                $sendCommentDatas->execute();
            }
            
        //Je compte les commentaires en bases de données
        public function count()
            {
                return $this->_db->query('SELECT COUNT(*) as nbCmt FROM comments')->fetchColumn();
            }
            
        //Je compte les commentaires en bases de données
        public function countChapterComments(Comment $comment)
            {
                $getNumberOfArticles = $this->_db->prepare('SELECT COUNT(*) as nbCmt FROM comments WHERE id_From_Article = :idFromArticle');
                //print_r($getNumberOfArticles);
                $getNumberOfArticles->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_STR);
                $getNumberOfArticles->execute();
                $count = $getNumberOfArticles->fetchColumn();
                return $count;   
            }
            
            
        //Je récupére 5 commentaires
        /*public function getListOfFiveComments($page,$nbrCommentsPerPage)
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
            }*/
        //Je récupére les commentaire en base de données pour les afficher en fonction de l'article
        public function getListOfComments(Comment $comment, $page, $nbrCommentsPerPage)
            {
                //$getComments = $this->_db->prepare("SELECT * FROM comments WHERE id_From_Article = :idFromArticle ORDER BY ID DESC LIMIT ".(($page-1)*$nbrCommentsPerPage).", $nbrCommentsPerPage ");
                $getComments = $this->_db->prepare("SELECT  a.firstname firstname , a.imageComment imageComment, c.create_date create_date, c.update_date update_date, c.content content, c.id_From_Article id_From_Article, c.id id FROM comments_author a INNER JOIN comments c ON a.id = c.id_comments_author  WHERE id_From_Article = :idFromArticle ORDER BY ID DESC LIMIT ".(($page-1)*$nbrCommentsPerPage).", $nbrCommentsPerPage");
                $getComments->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_STR );
                $getComments->execute();
                
                while ($donnees = $getComments->fetch())
                    {
                        $comment =  new Comment($donnees);

                        $commentDate = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        $comment->setCreatedate($commentDate);
                        
                        //Je vérifie si j'ai Null ou une date d'enregistré en bdd
                        if (is_null($donnees['update_date']))
                            {
                                //echo '<td>0000-00-00 00:00:00 </td>';

                                //print_r($articleUpdateDate); 
                            }
                        else
                            {
                                $commentUpdateDate =  DateTime::createFromFormat('Y-m-d H:i:s', $donnees['update_date']);
                                $comment->setUpdatedate($commentUpdateDate);
                            }
                        $datas[] = $comment;

                    }
                $data = $datas;
                return $data;
            }
        
        //Je récupére les commentaires pour les afficher dans le tableau datatables
        public function getComments()
            {
                //execute une requéte de type select avec une clause Where, et retourne un objet ArticlesManager. 

                $articles = [];
                
                $getArticlesDatas = $this->_db->prepare("SELECT id, create_date, content FROM comments");
                $getArticlesDatas->execute();

                while ($donnees = $getArticlesDatas->fetch())
                    {
                        $tmpArticle =  new Comment($donnees);

        
                        $articleDate = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        $tmpArticle->setCreatedate($articleDate);
                        
                        //Je vérifie si j'ai Null ou une date d'enregistré en bdd
                        /*if (is_null($donnees['update_date']))
                            {
                                //echo '<td>0000-00-00 00:00:00 </td>';

                                //print_r($articleUpdateDate); 
                            }
                        else
                            {
                                $articleUpdateDate =  DateTime::createFromFormat('Y-m-d H:i:s', $donnees['update_date']);
                                $tmpArticle->setUpdatedate($articleUpdateDate);
                            }*/
                        
                        $articles[] = $tmpArticle;
                    }
                
                $data = $articles;

                return $data;
            }
            
        //Je vais supprimer les commentaires en base de données  
        public function removeComment(Comment $comment)
            {
                //Executer une requéte de type delete.
                $this->_db->exec('DELETE FROM comments WHERE id = '.$comment->id());
            }
            
        public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
    }
