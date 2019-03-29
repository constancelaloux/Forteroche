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
            print_r($_GET['id']);
                if (isset($_POST['comments']) AND isset ($_GET['id']))
                    {
                        if (!empty($_POST['comments']) AND (!empty($_GET['id'])))
                            {
                                $comment = $_POST['comments'];
                                $id = $_GET['id'];
                                
                            }
                    }
                 $newComment = new Comment
                    ([
                        'content' => $comment,
                        'idFromArticle' =>$id
                        //'updatedate' => $date                  
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();


                $sendToTheCommentManager = new CommentsManager($db);

                //Je vais vers la fonction add de CommentsManager pour ajouter les données en base
                $sendToTheCommentManager->add($newComment);
                
                header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
            }
            
        function getFiveComments()
            {
                //Je récupére mes commentaires
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $sendToTheCommentManager = new CommentsManager($db);
                
                //On récupére le nombre de commentaires total en bdd
                $countCommentsFromManager = $sendToTheCommentManager->count();
                $nbrComments = $countCommentsFromManager;
                
                //Combien de commentaires souhaite t'on afficher par page
                $nbrCommentsPerPage = 5;
                //$numeroPageCourante = 1;

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
                
                $listOfCommentsFromManager = $sendToTheCommentManager->getListOfFiveComments($page,$nbrCommentsPerPage);

                //ALler chercher les articles en bdd
                //$articlesFromManager = $articlesManager->getList();//Appel d'une fonction de cet objet 
   
                //Je récupére mon dernier article en bdd
                //$lastComment = $articlesManager->getUnique();//Appel d'une fonction de cet objet
                //print_r($articlesFromManager);
                
                //$titleLastArticle = $lastArticle->subject();
                //$contentLastArticle = $lastArticle->content();
                //$imageLastArticle = $lastArticle->image();
                require 'Frontend/FrontendViews/Articles/MyArticles.php';
                //header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
            }
}
