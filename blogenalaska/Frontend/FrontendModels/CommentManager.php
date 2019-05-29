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

        //n'oubliez pas d'ajouter un setter pour notre manager afin de pouvoir modifier l'attribut$_db. 
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
                $getNumberOfArticles->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_STR);
                $getNumberOfArticles->execute();
                $count = $getNumberOfArticles->fetchColumn();
                return $count;   
            }
            
        //Je récupére les commentaire en base de données pour les afficher en fonction de l'article
        public function getListOfComments(Comment $comment, $page, $nbrCommentsPerPage)
            {
                //$datas = array();
                $getComments = $this->_db->prepare("SELECT  a.firstname firstname , a.imageComment imageComment, c.create_date create_date, c.update_date update_date, c.id_comments_author id_comments_author, c.content content, c.id_From_Article id_From_Article, c.id id FROM comments_author a INNER JOIN comments c ON a.id = c.id_comments_author "
                        . "WHERE id_From_Article = :idFromArticle ORDER BY ID DESC LIMIT ".(($page-1)*$nbrCommentsPerPage).", $nbrCommentsPerPage");
                $getComments->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_STR );
                $getComments->execute();
                
                while ($donnees = $getComments->fetch())
                    {
                        $comment =  new Comment($donnees);

                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        setlocale(LC_TIME, "fr_FR");
                        $commentDate = strftime("%H %B %Y", $date->getTimestamp());
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

                //$articles = array();
                
                $getArticlesDatas = $this->_db->prepare("SELECT a.subject subject, c.id id, c.create_date create_date, c.content content, c.countclicks countclicks FROM articles a INNER JOIN comments c ON a.id = c.id_From_Article WHERE c.status = 'unwanted' order by countclicks DESC");
  
                $getArticlesDatas->execute();

                while ($donnees = $getArticlesDatas->fetch())
                    {
                        $tmpArticle =  new Comment($donnees);

                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        setlocale(LC_TIME, "fr_FR");
                        $articleDate = strftime("%H %B %Y", $date->getTimestamp());
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
            
        public function addStatusOfComment(Comment $comment)
            {
                $sendStatusCommentDatas = $this->_db->prepare("UPDATE comments
                        SET status = (:status)
                        ,countclicks = :countclicks
                        WHERE id = :id");

                $sendStatusCommentDatas->bindValue(':status', $comment->status(), \PDO::PARAM_STR);
                $sendStatusCommentDatas->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
                $sendStatusCommentDatas->bindValue(':countclicks', $comment->countclicks(), \PDO::PARAM_INT);
                $sendStatusCommentDatas->execute();
            }
            
        public function getNumberOfClicksComment(Comment $comment)
            {
                $getNumberOfClicksDatas = $this->_db->prepare("SELECT countclicks FROM comments WHERE id = :id");
                $getNumberOfClicksDatas->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
                $getNumberOfClicksDatas->execute();
                return new Comment($getNumberOfClicksDatas->fetch());
            }
            
        //Je vais supprimer les champs status et countclicks en fonction de l'id en base de données
        public function validateComment(Comment $comment)
            {
                //Executer une requéte de type delete.
                $this->_db->exec('UPDATE comments SET status = "", countclicks = 0 WHERE id = '.$comment->id());
            }
            
        public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
    }
