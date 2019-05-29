<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/FrontendModels/Comment.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';

//require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/frontend/FrontendModels/CommentManager.php';
class commentsAdminControler
    {
        //Je vais vers la vue avec le tableau des commentaires
        function getCommentsView()
            {
                require 'Backend/BackendViews/BackendViewfolders/ManageCommentsview.php';  
            }
        
        //Je vais récupérer les commentaires en base de données
        function getCommentsIntoDatatables()
            {
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $commentsManager = new CommentsManager($db); 
                //ALler chercher les articles en bdd
                $commentsFromManager = $commentsManager->getComments();//Appel d'une fonction de cet objet

                foreach ($commentsFromManager as $comments) 
                    {
                    //print_r($comments);
                        //$row = array();
                        //$data = array();
;                       $row = array();
                        $row[] = $comments->id();

                        $row[] = $comments->createdate();
                        //$row[] = $commentDate;//->format('Y-m-d');
                        
                        $row[] = $comments->subject();
                        
                        if (strlen($comments->content()) <= 400)
                            {
                                 $row[] = $comments->content();
                            }
                        else
                            {
                            //Returns the portion of string specified by the start and length parameters.
                                $debut = substr($comments->content(), 0, 400);
                                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                                 $row[] = $debut;
                                 
                            }
                        //$row[] = $comments->content();
                        //$updateCommentDate = $comments->updatedate();
                        
                        /*if (is_null($updateCommentDate))
                            {
                                $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                            }
                        else 
                            {
                                $row[] = $updateCommentDate->format('Y-m-d');
                            }*/

                        $row[] = $comments->countclicks();
                        //print_r($row);
                        $data[] = $row;

                    }
                        // Structure des données à retourner
                        $json_data = array
                            (
                                "data" => $data
                            );
                        
                        echo json_encode($json_data);
            }
            
        function removeComments()
            {
                if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                                // check if the id has been set
                                $myIdComment = ($_POST['id']);
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                require'/Backend/BackendViews/BackendViewFolders/ManageCommentsView.php';
                            }
                    }  
                    $comment = new Comment
                        ([

                            'id' => $myIdComment
                        ]);

                    $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                    $commentsManager = new CommentsManager($db);

                    $commentsManager->removeComment($comment);
            }
        
        //Valider les commentaires
        function validateComment()
            {
                           if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                                // check if the id has been set
                                $myIdComment = ($_POST['id']);
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                require'/Backend/BackendViews/BackendViewFolders/ManageCommentsView.php';
                            }
                    }  
                    $comment = new Comment
                        ([

                            'id' => $myIdComment
                        ]);

                    $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                    $commentsManager = new CommentsManager($db);

                    $commentsManager->validateComment($comment);
            }
    }