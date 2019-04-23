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
            //print_r("j y suis");
                require 'Backend/BackendViews/BackendViewfolders/ManageCommentsview.php';  
            }
        
        //Je vais récupérer les commentaires en base de données
        function getCommentsIntoDatatables()
            {
                //print_r("j y suis");
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $commentsManager = new CommentsManager($db); 
                //ALler chercher les articles en bdd
                $commentsFromManager = $commentsManager->getComments();//Appel d'une fonction de cet objet

                foreach ($commentsFromManager as $comments) 
                    {
                        $row = array();
                        $row[] = $comments->id();
                        $row[] = $comments->content();

                        $commentDate = $comments->createdate();
                        $row[] =$commentDate->format('Y-m-d');

                        //$updateCommentDate = $comments->updatedate();
                        
                        /*if (is_null($updateCommentDate))
                            {
                                $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                            }
                        else 
                            {
                                $row[] = $updateCommentDate->format('Y-m-d');
                            }*/


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

            }
    }