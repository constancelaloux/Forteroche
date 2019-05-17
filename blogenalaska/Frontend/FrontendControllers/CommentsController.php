<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';
require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/FrontendModels/Comment.php';
require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/FrontendModels/CommentManager.php';

class CommentsController
    {
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

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();


                $sendToTheCommentManager = new CommentsManager($db);

                //Je vais vers la fonction add de CommentsManager pour ajouter les données en base
                $sendToTheCommentManager->add($newComment);
                header("Location: /blogenalaska/index.php?action=getArticleFromId&id=$id");              
            }
            
        //Je récupére les commentaires pour les afficher sur l'article selectionné en fonction de l'id    
        function getListOfComments()
            {
                if (isset($_GET['id']))
                        {
                            if (!empty($_GET['id']))
                                {
                                    $myIdComment = ($_GET['id']);
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

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $commentManager = new CommentsManager($db);
                
                //Je vais compter mes articles
                
               //On récupére le nombre d'articles total en bdd
                $countCommentsFromManager = $commentManager->count();
                $nbrComments = $countCommentsFromManager;
                
                //Combien d'articles souhaite t'on par page
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
            
        //Fonction qui compte les commentaires en fonction de l'id de l'article
        function countComments()
            {
                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
                                $myIdComment = ($_GET['id']);
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
               $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $commentManager = new CommentsManager($db);

                $commentsCount = $commentManager->countChapterComments($comment);
                
                return $commentsCount;
                //require 'Backend/BackendViews/BackendViewFolders/BackendView.php';
            }
        
        //Je signale un commentaire indésirable à l'administrateur du site
        //Et j'ajoute la mention indésirable en base de données
        function unwantedComments()
            {
               if (isset($_POST['id']) AND isset ($_GET['p']) AND isset ($_GET['idarticle']) AND isset ($_POST['number']))
                    {
                        if (!empty($_POST['id']) AND (!empty($_GET['p'])) AND(!empty($_GET['idarticle'])) AND(!empty($_POST['number'])))

                            {
                                $myIdComment = ($_POST['id']);
                                $unwantedComment = ($_GET['p']);
                                $id = ($_GET['idarticle']);
                                $number = ($_POST['number']);
                            }
                        else 
                            {
                                echo 'pas de commentaire séléctionné';
                            }
                    }
                    
                $comment = new Comment
                        ([

                            'id' => $myIdComment,
                            //'status' => $unwantedComment,
                            'countclicks'=>$number

                        ]);
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $commentManager = new CommentsManager($db);
                $nbrClicks = $commentManager->getNumberOfClicksComment($comment);
                //print_r($nbrClicks);
                $clicks = $nbrClicks->countclicks();
                
                $clicksIncremented = $clicks + $number;
                header("Location: /blogenalaska/index.php?action=addStatusAndNumberOfClicksToComment&id=$id&idcomment=$myIdComment&unwantedcomment=$unwantedComment&clicks=$clicksIncremented");
                //print_r($clicks);
                //exit();
            }
        function addStatusAndNumberOfClicksToComment()
            {
            //print_r($_GET['id']);
            //exit();
               if (isset($_GET['id']) AND isset ($_GET['idcomment']) AND isset ($_GET['unwantedcomment']) AND isset ($_GET['clicks']))
                    {
                        if (!empty($_GET['id']) AND (!empty($_GET['idcomment'])) AND(!empty($_GET['unwantedcomment'])) AND(!empty($_GET['clicks'])))
                            {
                                $myIdComment = ($_GET['idcomment']);
                                $unwantedComment = ($_GET['unwantedcomment']);
                                $id = ($_GET['id']);
                                $numberOfClicks = ($_GET['clicks']);
                            }
                  
                    }
                    
                $comment = new Comment
                    ([

                            'id' => $myIdComment,
                            'status' => $unwantedComment,
                            'countclicks'=>$numberOfClicks
                    ]);
                
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();
                $commentManager = new CommentsManager($db);           
                $commentManager->addStatusOfComment($comment);
                header("Location: /blogenalaska/index.php?action=getArticleFromId&id=$id");
            }
    }
