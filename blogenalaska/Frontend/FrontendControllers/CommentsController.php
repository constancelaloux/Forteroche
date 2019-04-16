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
                //print_r($_GET['id']);
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
                header("Location: /blogenalaska/index.php?action=getArticleFromId&id=$id");
                //require 'Frontend/FrontendViews/Articles/MyArticles.php';
                
            }
            
        function getListOfComments()
            {
            //print_r($_GET['id']);
                if (isset($_GET['id']))
                        {
                    //print_r("meuhh");
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
                
                
            //print_r($comment);
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $commentManager = new CommentsManager($db);
                
                //Je vais compter mes articles
                
               //On récupére le nombre d'articles total en bdd
                $countArticlesFromManager = $commentManager->count();
                $nbrComments = $countArticlesFromManager;
                //print_r($nbrComments);
                
                //Combien d'articles souhaite t'on par page
                $nbrCommentsPerPage = 5;
                //$numeroPageCourante = 1;

                $numberOfPages = ceil($nbrComments/$nbrCommentsPerPage);
                
                if (isset($_GET['p']))
                    {
                    //print_r($_GET['p']);
                        $page = $_GET['p'];
                        //print_r($page);
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
                //print_r($listOfComments);
                //require 'Frontend/FrontendViews/Articles/MyArticles.php';
                //print_r($listOfCommentsFromManager);
                //include 'Frontend/FrontendViews/Articles/MyArticles.php';
            }
    }
