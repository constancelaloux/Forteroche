<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendControllers;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();*/

require_once'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/models/PdoConnection.php';
require'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/models/Comment.php';
require_once'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/models/CommentsManager.php';
require_once'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/session/SessionClass.php';

class CommentsController
    {

//ENVOYER UN COMMENTAIRE EN BASE DE DONNEES
        //création et envoi d'un commentaire en base de données
        function createNewComment()
            {
                if (isset($_POST['comments']) AND isset ($_GET['id']) AND isset ($_GET['idClient']))
                    {

                        if (!empty($_POST['comments']) AND (!empty($_GET['id'])) AND (!empty($_GET['idClient'])))

                            {
                                $comment = $_POST['comments'];
                                $id = $_GET['id']; 
                                $idClient = $_GET['idClient'];
                            }
                    }
                    
                 $newComment = new Comment
                    ([
                        'content' => $comment,
                        'idFromArticle' =>$id,
                        'id_comments_author' => $idClient
                    ]);

                $db = PdoConnection::connect();


                $sendToTheCommentManager = new CommentsManager($db);

                //Je vais vers la fonction add de CommentsManager pour ajouter les données en base
                $sendToTheCommentManager->add($newComment);
                header("Location: /public/index.php?action=getArticleFromId&id=$id");              
            }
//FIN ENVOYER COMMENTAIRE EN BASE DE DONNEES

            
            
//JE RECUPERE LES COMMENTAIRES POUR LES AFFICHER
        //Je récupére les commentaires pour les afficher sur l'article selectionné en fonction de l'id    
        function getListOfComments()
            {
                if (isset($_GET['id']))
                        {
                            if (!empty($_GET['id']))
                                {
                                    $myIdComment = $_GET['id'];
                                }
                            else 
                                {
                                    echo 'pas de commentaire séléctionné';
                                }
                        }

                $comment = new Comment
                        ([

                            'idFromArticle' => $myIdComment

                        ]);

                $db = PdoConnection::connect();

                $commentManager = new CommentsManager($db);
                
                //Je vais compter mes commentaires
                
               //On récupére le nombre de commentaires total en bdd
                $countCommentsFromManager = $commentManager->count();
                $nbrComments = $countCommentsFromManager;
                
                //Combien de commentaires souhaite t'on par page
                $nbrCommentsPerPage = 5;

                $numberOfPages = ceil($nbrComments/$nbrCommentsPerPage);
                
                if (isset($_GET['p']))
                    {
                        $page = $_GET['p'];
                        $nextpage = $page + 1;
                        $prevpage = $page - 1;
                        
                        if($prevpage  < 1)
                            {
                                $prevpage = $numberOfPages;
                            }
                        
                        if($nextpage > $numberOfPages)
                            {
                                $nextpage = 1;
                            }
                    } 
                else
                    {
                        $page = 1;
                    }
                $listOfComments = $commentManager->getListOfComments($comment,$page,$nbrCommentsPerPage);

                return $listOfComments;

            }
//FIN JE RECUPERE LES COMMENTAIRES           
    
            
            
//JE VAIS COMPTER LES COMMENTAIRES DE L'ARTICLE POUR AFFICHER LE NOMBRE DE COMMENTAIRES SUR CET ARTICLE 
// SUR LE FRONTEND          
        //Fonction qui compte les commentaires en fonction de l'id de l'article
        function countComments()
            {
                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
                                $myIdComment = $_GET['id'];
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                            }
                    }

                $comment = new Comment
                        ([

                            'idFromArticle' => $myIdComment

                        ]);
               $db = PdoConnection::connect();

                $commentManager = new CommentsManager($db);

                $commentsCount = $commentManager->countChapterComments($comment);
                
                return $commentsCount;
            }
//FIN JE VAIS COMPTER LES COMMENTAIRES        


            
//JE VAIS MODIFIER UN COMMENTAIRE
        //Je récupére mon commentaire pour aller le modifier
        function getCommentFromIdBeforeToUpdate()
            {
                if (isset($_GET['idComment']))
                    {
                        if (!empty($_GET['idComment']))
                            {
                                // check if the id has been set
                                $myIdComment = $_GET['idComment'];
                                $id = $_GET['id'];
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas de commentaire séléctionné','error');
                            }
                    }
            
                $comment = new Comment
                    ([
                        'id' => $myIdComment
                    ]);

                $db = PdoConnection::connect();

                $commentManager = new CommentsManager($db);

                $myCommentToModify = $commentManager->get($comment);
                
                if(!empty($myCommentToModify))
                    {
                        $articleFromId = new BlogController();
                        $getArticleFromId = $articleFromId->getTheArticleFromId();
                        $commentContent = $myCommentToModify->content();
                        $idComment = $myCommentToModify->id();
                        require_once '/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/MyArticles.php';
                    }
                else
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article trouvé','error');
                        header('Location: /public/index.php?action=getArticleFromId');
                        //require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/FrontendViews/Articles/MyArticles.php';
                    }
            }
            
        function updateComment()
            {
            
                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
                                // check if the id has been set
                                $id = $_GET['id'];
                                $myContentOfComment = $_POST['comments'];
                                $idArticle = $_GET['idArticle'];
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article sélectionné','error');
                                require_once'/src/blogenalaskaFram/views/MyArticles.php';
                            }
                    } 
                        
                $comment = new Comment
                    ([
                        'content' => $myContentOfComment,
                        'id' => $id,
                    ]);

                $db = PdoConnection::connect();

                $commentManager = new CommentsManager($db);
                $commentManager->update($comment);
                header("Location: /public/index.php?action=getArticleFromId&id=$idArticle");
                //header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');

            }
//FIN JE VAIS MODIFIER UN COMMENTAIRE

            
            
//SUPPRIMER UN COMMENTAIRE
        function removeComment()
            {
                if (isset($_GET['idComment']))
                    {
                        if (!empty($_GET['idComment']))
                            {
                                // check if the id has been set
                                $idComment = $_GET['idComment'];
                                $idArticle = $_GET['id'];
                            }
                        else 
                            {
                                echo 'pas de commentaire séléctionné';
                                require_once'/src/blogenalaskaFram/views/MyArticles.php';
                            }
                    }  
                $comment = new Comment
                    ([

                        'id' => $idComment
                    ]);

                $db = PdoConnection::connect();

                $commentsManager = new CommentsManager($db);

                $commentsManager->removeComment($comment);
                
                header("Location: /public/index.php?action=getArticleFromId&id=$idArticle");

            }
//FIN SUPPRIMER UN COMMENTAIRE

            
            
//SIGNALEMENT COMMENTAIRE         
        //Je récupére le nombre de signalement en base de données
        function unwantedComments()
            {
               if (isset($_POST['id']) AND isset ($_GET['p']) AND isset ($_GET['idarticle']) AND isset ($_POST['number']))
                    {
                        if (!empty($_POST['id']) AND (!empty($_GET['p'])) AND(!empty($_GET['idarticle'])) AND(!empty($_POST['number'])))

                            {
                                $myIdComment = $_POST['id'];
                                $unwantedComment = $_GET['p'];
                                $id = $_GET['idarticle'];
                                $number = $_POST['number'];
                            }
                        else 
                            {
                                echo 'pas de commentaire séléctionné';
                            }
                    }
                    
                $comment = new Comment
                        ([

                            'id' => $myIdComment,
                            'countclicks'=>$number

                        ]);
                $db = PdoConnection::connect();

                $commentManager = new CommentsManager($db);
                $nbrClicks = $commentManager->getNumberOfClicksComment($comment);

                $clicks = $nbrClicks->countclicks();
                
                $clicksIncremented = $clicks + $number;
                
                header("Location: /public/index.php?action=addStatusAndNumberOfClicksToComment&id=$id&idcomment=$myIdComment&unwantedcomment=$unwantedComment&clicks=$clicksIncremented");
            }
            
        //Je signale un commentaire indésirable à l'administrateur du site
        //Et j'ajoute la mention indésirable et je modifie le nombre de signalements en base de données       
        function addStatusAndNumberOfClicksToComment()
            {
               if (isset($_GET['id']) AND isset ($_GET['idcomment']) AND isset ($_GET['unwantedcomment']) AND isset ($_GET['clicks']))
                    {
                        if (!empty($_GET['id']) AND (!empty($_GET['idcomment'])) AND(!empty($_GET['unwantedcomment'])) AND(!empty($_GET['clicks'])))
                            {
                                $myIdComment = $_GET['idcomment'];
                                $unwantedComment = $_GET['unwantedcomment'];
                                $id = $_GET['id'];
                                $numberOfClicks = $_GET['clicks'];
                            }
                    }
                    
                $comment = new Comment
                    ([

                            'id' => $myIdComment,
                            'status' => $unwantedComment,
                            'countclicks'=>$numberOfClicks
                    ]);
                
                $db = PdoConnection::connect();
                $commentManager = new CommentsManager($db);           
                $commentManager->addStatusOfComment($comment);
                
                header("Location: /public/index.php?action=getArticleFromId&id=$id");
            }
//FIN SIGNALEMENT COMMENTAIRE
    }
