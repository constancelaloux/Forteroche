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
        function createNewComment()
            {
                if (isset($_POST['comments']) AND isset ($_GET['id']))
                    {

                        if (!empty($_POST['comments']) AND (!empty($_GET['id'])))

                            {
                                $title = $_POST['title'];
                                $comment = $_POST['comments'];
                                $id = $_GET['id']; 
                                $myImg = ($_POST['image']);
                            }
                    }
                 $newComment = new Comment
                    ([
                        'title' => $title,
                        'content' => $comment,
                        'idFromArticle' =>$id,
                        'image' => $myImg
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
                //print_r($commentsCount);
                
                return $commentsCount;
                //require 'Backend/BackendViews/BackendViewFolders/BackendView.php';
            }
    }
