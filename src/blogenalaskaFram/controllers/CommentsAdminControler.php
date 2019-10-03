<?php
//namespace Forteroche\blogenalaska\Backend\BackendControllers;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Chargement des classes
/*require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();*/

require_once'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/models/PdoConnection.php';
require_once'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/models/CommentsManager.php';
require_once'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/models/Comment.php';
require_once'/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/session/SessionClass.php';
//Applications/MAMP/htdocs/Forteroche/blogenalaska/views/

class commentsAdminControler
    {
//COMMENTAIRES DATATABLES VUE
        //Je vais vers la vue avec le tableau des commentaires
        function getCommentsView()
            {
                //require 'Backend/BackendViews/BackendViewfolders/ManageCommentsview.php'; 
                header('Location: /public/index.php?action=countCommentsForAdminTableView');
            }
//FIN COMMENTAIRES DATATABLES VUE

            
            
//COMPTER LES COMMENTAIRES
        //Je vais compter les commentaires en base de données et ceux qui ont été signalés
        function countComments()
            {
                $status = 'unwanted';
                $db = PdoConnection::connect();

                $commentsManager = new CommentsManager($db); 
                //ALler chercher les articles en bdd
                $globalCommentsCount = $commentsManager->count();//Appel d'une fonction de cet objet
                
                if(empty($globalCommentsCount))
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas de données','error');     
                    }
                    

                $unwantedCommentsCount = $commentsManager->countUnwantedComments($status);//Appel d'une fonction de cet objet
                
                if(empty($unwantedCommentsCount))
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas de données','error');     
                    }
                    
                if(file_exists('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsview.php'))   
                    {
                        require_once '/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsview.php';
                    }
                else
                    {
                        header('Location: /src/blogenalaskaFram/views/Page404.php');
                    }
            }
//FIN COMPTER LES COMMENTAIRES

            

//DATATABLES COMMENTAIRES
        //Je vais récupérer les commentaires en base de données
        function getCommentsIntoDatatables()
            {
                $status = 'unwanted';
                $db = PdoConnection::connect();
                
                $commentsManager = new CommentsManager($db); 
                //ALler chercher les articles en bdd
                $commentsFromManager = $commentsManager->getComments($status);//Appel d'une fonction de cet objet

                foreach ($commentsFromManager as $comments) 
                    {
                        //$data = array();
                        $row = array();
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

                        $updateCommentDate = $comments->updatedate();
                        
                        if (is_null($updateCommentDate))
                            {
                                $row[] = "Pas de modifications faites sur ce commentaire pour l'instant";
                            }
                        else 
                            {
                                $row[] = $updateCommentDate;
                            }

                        $row[] = $comments->countclicks();
                        $data[] = $row;

                    }
                        // Structure des données à retourner
                        $json_data = array
                            (
                                "data" => $data
                            );
                        
                    echo json_encode($json_data);
            }
//FIN DATATABLES COMMENTAIRES

            

//SUPPRIMER LES COMMENTAIRES
        //Je supprime les commentaires indésirables     
        function removeComments()
            {
                if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                                // check if the id has been set
                                $myIdComment = $_POST['id'];
                                $comment = new Comment
                                    ([

                                        'id' => $myIdComment
                                    ]);

                                $db = PdoConnection::connect();

                                $commentsManager = new CommentsManager($db);

                                $commentsManager->removeComment($comment);
                            }
                        else 
                            {
                                //echo 'pas d article séléctionné';
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article séléctionné','error');
                                //require_once'/Backend/BackendViews/BackendViewFolders/ManageCommentsView.php';
                                if (file_exists('Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php'))
                                    {
                                        require_once'Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php';
                                    }
                                else
                                    {
                                        header('Location: /src/blogenalaskaFram/view/Page404.php');
                                    }
                            }
                    } 
                else
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article séléctionné','error');
                        //require_once'/Backend/BackendViews/BackendViewFolders/ManageCommentsView.php';
                        if (file_exists('Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php'))
                            {
                                require_once'Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php';
                            }
                        else
                            {
                                header('Location: /src/blogenalaskaFram/views/Page404.php');
                            }
                    }
            }
//FIN SUPPRIMER LES COMMENTAIRES

            
            
//VALIDER LES COMMENTAIRES INDESIRABLES
        //Valider les commentaires qui ont été considérés comme indésirables par les visiteurs
        function validateComment()
            {
                if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                                // check if the id has been set
                                $myIdComment = $_POST['id'];
                                $status = '';
                                $countclicks = '0';
                
                                $comment = new Comment
                                    ([

                                        'id' => $myIdComment,
                                        'status' => $status,
                                        'countclicks' => $countclicks
                                    ]);

                                $db = \Forteroche\blogenalaska\PdoConnection::connect();
                    
                                $commentsManager = new CommentsManager($db);

                                $commentsManager->validateComment($comment);
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article séléctionné','error');
                                //echo 'pas d article séléctionné';
                                //require_once'/Backend/BackendViews/BackendViewFolders/ManageCommentsView.php';
                                if (file_exists('Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php'))
                                    {
                                        require_once'Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php';
                                    }
                                else
                                    {
                                        header('Location: /src/blogenalaskaFram/views/Page404.php');
                                    }
                            }
                    } 
                else 
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article séléctionné','error');
                        //echo 'pas d article séléctionné';
                        //require_once'/Backend/BackendViews/BackendViewFolders/ManageCommentsView.php';
                        if (file_exists('Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php'))
                            {
                                require_once'Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ManageCommentsView.php';
                            }
                        else
                            {
                                header('Location: /src/blogenalaskaFram/views/Page404.php');
                            }
                    }
            }
//FIN VALIDER LES COMMENTAIRES INDESIRABLES
    }