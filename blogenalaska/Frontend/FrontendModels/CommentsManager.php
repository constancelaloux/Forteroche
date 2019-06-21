<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendModels;
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

//BACKEND
//JE COMPTE LES COMMENTAIRES            
        //Je compte les commentaires en bases de données
        public function count()
            {
                return $this->_db->query('SELECT COUNT(*) as nbCmt FROM comments')->fetchColumn();
            }
            
        //Je compte les commentaires qui ont été signalés en base de données
        public function countUnwantedComments($status)
            {
                $comments = $this->_db->prepare('SELECT COUNT(*) as nbCmt FROM comments WHERE status = :status');
                $comments->execute([':status' => $status]);
                return $comments->fetchColumn();
            }
//FIN JE COMPTE LES COMMENTAIRES

            
            
//DATATABLES COMMENTAIRES
        //Je récupére les commentaires pour les afficher dans le tableau datatables
        public function getComments($status)
            {
                //execute une requéte de type select avec une clause Where, et retourne un objet ArticlesManager. 
                $comments = array();
                
                $getCommentsDatas = $this->_db->prepare("SELECT a.subject subject, "
                        . "c.id id, c.create_date create_date, c.update_date update_date, c.content content, c.countclicks countclicks "
                        . "FROM articles a "
                        . "INNER JOIN comments c ON a.id = c.id_From_Article "
                        . "WHERE c.status = :status order by countclicks DESC");
                //$getArticlesDatas->bindValue(':status', $comment->status(), \PDO::PARAM_STR);
                $getCommentsDatas->execute(([':status' => $status]));

                while ($donnees = $getCommentsDatas->fetch())
                    {
                        $tmpComments =  new Comment($donnees);

                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        setlocale(LC_TIME, "fr_FR");
                        $commentDate = strftime("%d %B %Y", $date->getTimestamp());
                        $tmpComments->setCreatedate($commentDate);
                        
                        //Je vérifie si j'ai Null ou une date d'enregistré en bdd
                        if (!is_null($donnees['update_date']))
                            {
                                $commentUpdateDate =  DateTime::createFromFormat('Y-m-d H:i:s', $donnees['update_date']);
                                setlocale(LC_TIME, "fr_FR");
                                $commentDate = strftime("%d %B %Y", $commentUpdateDate->getTimestamp());
                                $tmpComments->setUpdatedate($commentDate);
                            }
                        
                        $comments[] = $tmpComments;
                    }
                
                $data = $comments;

                return $data;
            }
//FIN DATATABLES COMMENTAIRES

            
 
//FIN SUPPRIMER COMMENTAIRES
        //Je vais supprimer les commentaires en base de données  
        public function removeComment(Comment $comment)
            {
                //Executer une requéte de type delete.
                $this->_db->exec('DELETE FROM comments WHERE id = '.$comment->id());
            }
//FIN SUPPRIMER COMMENTAIRES

            
            
//JE VALIDE UN COMMENTAIRE
        //Je vais supprimer les champs status et countclicks en fonction de l'id en base de données
        public function validateComment(Comment $comment)
            {
                //Executer une requéte de type delete.
                $validateComment = $this->_db->prepare('UPDATE comments SET status = :status, countclicks = :countclicks WHERE id = '.$comment->id());
                $validateComment->bindValue(':status', $comment->status(), \PDO::PARAM_STR);
                $validateComment->bindValue(':countclicks', $comment->countclicks(), \PDO::PARAM_INT);
                $validateComment->execute();
            }
//FIN VALIDER UN COMMENTAIRE
//FIN BACKEND      
    
            
   
            
            
            
            
            
            
//FRONTEND 
//COMPTER LES COMMENTAIRES          
        //Je compte les commentaires en bases de données
        public function countChapterComments(Comment $comment)
            {
                $getNumberOfComments = $this->_db->prepare('SELECT COUNT(*) as nbCmt FROM comments WHERE id_From_Article = :idFromArticle');
                $getNumberOfComments->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_INT);
                $getNumberOfComments->execute();
                $countComments = $getNumberOfComments->fetchColumn();
                return $countComments;   
            }
//FIN COMPTER LES COMMENTAIRES

            
            
//RECUPERER LES COMMENTAIRES
        //Je récupére les commentaire en base de données pour les afficher en fonction de l'article
        public function getListOfComments(Comment $comment, $page, $nbrCommentsPerPage)
            {
                $datas = array();
                $getComments = $this->_db->prepare("SELECT  a.username username , a.imageComment imageComment, "
                        . "c.create_date create_date, c.update_date update_date, c.id_comments_author id_comments_author, c.content content, c.id_From_Article id_From_Article, c.id id "
                        . "FROM comments_author a INNER JOIN comments c ON a.id = c.id_comments_author "
                        . "WHERE id_From_Article = :idFromArticle ORDER BY ID DESC LIMIT ".(($page-1)*$nbrCommentsPerPage).", $nbrCommentsPerPage");
                $getComments->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_INT );
                $getComments->execute();
                
                while ($donnees = $getComments->fetch())
                    {
                        $comment =  new Comment($donnees);

                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        setlocale(LC_TIME, "fr_FR");
                        $commentDate = strftime("%d %B %Y", $date->getTimestamp());
                        $comment->setCreatedate($commentDate);
                        
                        //Je vérifie si j'ai Null ou une date d'enregistré en bdd
                        if (!is_null($donnees['update_date']))
                            {
                                $commentUpdateDate =  DateTime::createFromFormat('Y-m-d H:i:s', $donnees['update_date']);
                                setlocale(LC_TIME, "fr_FR");
                                $commentDateUpdated = strftime("%d %B %Y", $commentUpdateDate->getTimestamp());
                                $comment->setUpdatedate($commentDateUpdated);
                            }
                        $datas[] = $comment;

                    }
                $data = $datas;
                return $data;
            }
//FIN RECUPERER LES COMMENTAIRES   
            
            
            
//AJOUTER UN COMMENTAIRE EN BDD
        //J'ajoute un commentaire en bdd
        public function add(Comment $comment)
            {
                $sendCommentDatas = $this->_db->prepare('INSERT INTO comments (content, id_From_Article, create_date, id_comments_author) '
                        . 'VALUES(:content, :idFromArticle, NOW(), :id_comments_author)');

                $sendCommentDatas->bindValue(':content', $comment->content(), \PDO::PARAM_STR);
                $sendCommentDatas->bindValue(':idFromArticle', $comment->idFromArticle(), \PDO::PARAM_INT);
                $sendCommentDatas->bindValue(':id_comments_author', $comment->id_comments_author(), \PDO::PARAM_INT);
                $sendCommentDatas->execute();
            }
//FIN AJOUTER UN COMMENTAIRE EN BDD
  
            
            
//MODIFIER UN COMMENTAIRE
        //Je récupére un commentaire en fonction de l'id pour ensuite aller le modifier
        public function get(Comment $comment)
            {
                $getCommentDatasFromId = $this->_db->prepare("SELECT * FROM comments WHERE id = :id");

                $getCommentDatasFromId->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
                $getCommentDatasFromId->execute();

                return new Comment($getCommentDatasFromId->fetch(\PDO::FETCH_ASSOC));     
            }
            
        public function update(Comment $comment)
            {
                $dbRequestModifyComment = $this->_db->prepare('UPDATE comments SET content = :content WHERE id = :id');

                $dbRequestModifyComment->bindValue(':content', $comment->content(), \PDO::PARAM_STR);
                $dbRequestModifyComment->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
                $dbRequestModifyComment->execute();
            }
//FIN MODIFIER UN COMMENTAIRE

            
            
//JE VAIS RECUPERER LE NOMBRE DE CLICKS SUR CE COMMENTAIRE POUR POUVOIR L'INCREMENTER ET METTRE A JOUR EN BDD
        public function getNumberOfClicksComment(Comment $comment)
            {
                $getNumberOfClicksDatas = $this->_db->prepare("SELECT countclicks FROM comments WHERE id = :id");
                $getNumberOfClicksDatas->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
                $getNumberOfClicksDatas->execute();
                return new Comment($getNumberOfClicksDatas->fetch());
            }
            
        public function addStatusOfComment(Comment $comment)
            {
                $sendStatusCommentDatas = $this->_db->prepare("UPDATE comments
                        SET status = :status
                        ,countclicks = :countclicks
                        WHERE id = :id");

                $sendStatusCommentDatas->bindValue(':status', $comment->status(), \PDO::PARAM_STR);
                $sendStatusCommentDatas->bindValue(':id', $comment->id(), \PDO::PARAM_INT);
                $sendStatusCommentDatas->bindValue(':countclicks', $comment->countclicks(), \PDO::PARAM_INT);
                $sendStatusCommentDatas->execute();
            }
//FIN JE VAIS RECUPERER LE NOMBRE DE CLICKS SUR CE COMMENTAIRE POUR POUVOIR L'INCREMENTER
//FIN FRONTEND
            
            
            
        public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
    }
