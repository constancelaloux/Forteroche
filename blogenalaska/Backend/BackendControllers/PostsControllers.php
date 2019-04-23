<?php

// Chargement des classes
//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//Autoloader::register();

require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/Article.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';

require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/ArticlesManager.php';

class PostsControllers
    {
        //Bouton écrire un article du menu pour afficher la page de redaction d'articles
        function writeAnArticle()
            {
                header('Location: /blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php');
            }
            
        //Envoyer des articles en base de données
        function createNewArticle()
            {       

                if (isset($_POST['content']) AND isset($_POST['title']) AND isset($_POST['image']))
                        {
                            if (!empty($_POST['content']) && !empty($_POST['title']) && !empty($_POST['image']))
                                {
                                    $myText = ($_POST['content']);
                 

                                    $myTitle = ($_POST['title']);

                                    $myImg = ($_POST['image']);
                                }
                            else 
                                {
                                    // On fait un écho si les variables sont vides
                                    //echo('Les champs ne sont pas remplis');
                                    require'/Forteroche/blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php';        
                                } 
                        }
                    
                $newArticles = new Article
                    ([
                        'subject' => $myTitle,
                        'content' => $myText,
                        'image' => $myImg                     
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();


                $sendToTheArticlesManager = new ArticlesManager($db);

                //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
                $sendToTheArticlesManager->add($newArticles);
                
                header('Location: /blogenalaska/index.php?action=mainBackendPage');
            }
        
        //Récupérer la page principale du Backend
        function getMainBackendPage()
            {
                header('Location: /blogenalaska/index.php?action=countArticles');
            }
            
        //Fonction qui compte les articles
        function countArticles()
            {
            //print_r("jysuis je compte mes articles");
               $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $articlesCount = $articlesManager->count();

                require 'Backend/BackendViews/BackendViewFolders/BackendView.php';
            }

        //Récupérer des articles de la base de données
        function getArticles()
            {    
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                //ALler chercher les articles en bdd
                $articlesFromManager = $articlesManager->getList();//Appel d'une fonction de cet objet

                foreach ($articlesFromManager as $articles) 
                    {
                        $row = array();
                        $row[] = $articles->id();
                        $row[] = $articles->subject();

                        $articleDate = $articles->createdate();
                        $row[] =$articleDate->format('Y-m-d');

                        $updateArticleDate = $articles->updatedate();
                        
                        if (is_null($updateArticleDate))
                            {
                                $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                            }
                        else 
                            {
                                $row[] = $updateArticleDate->format('Y-m-d');
                            }


                        $data[] = $row;
                    }
                        // Structure des données à retourner
                        $json_data = array
                            (
                                "data" => $data
                            );

                        echo json_encode($json_data);
            }
        
            
        //Supprimer des articles en base de données
        function deleteArticles()
            {
                if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                                // check if the id has been set
                                $myIdArticle = ($_POST['id']);
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                require'/Backend/BackendViews/BackendViewFolders/BackendView.php';
                            }
                    }  
                $article = new Article
                    ([

                        'id' => $myIdArticle

                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $articlesManager->delete($article);

            }

        //Aller réupérer le titre et l'article en base de données    
        function getArticlesFromId()
            {
                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
                                // check if the id has been set
                                $myIdArticle = ($_GET['id']);
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                            }
                    }
            
                $article = new Article
                    ([
                        'id' => $myIdArticle
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $myArticlesToModify = $articlesManager->get($article);

                $articleSubject = $myArticlesToModify->subject();
                $articleContent = $myArticlesToModify->content();
                $articleImage = $myArticlesToModify->image();

                $id = $myArticlesToModify->id();

                require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/BackendViewFolders/ModifyArticlesView.php';
            }
        
        //Modifier les données de l'article en base de données apres validation
        function update()
            {
                if (isset($_POST['id']))
                        {
                            if (!empty($_POST['id']))
                                {

                                    // check if the id has been set
                                    $id = ($_POST['id']);
                                    $myContentOfArticle = ($_POST['content']);
                                    $myTitleOfArticle = ($_POST['title']);
                                }
                            else 
                                {
                                    echo 'pas d article séléctionné';
                                    require'/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php';
                                }
                        } 
                        
                    $article = new Article
                        ([
                            'content' => $myContentOfArticle,
                            'subject' => $myTitleOfArticle,
                            'id' => $id
                        ]);

                    $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                    $articlesManager = new ArticlesManager($db);
                    $articlesManager->update($article);
                    header('Location: /blogenalaska/index.php?action=mainBackendPage');
            }

        //Sauvegarder des données en base de données sans les afficher dans une vue   
        function saveArticlesIntoDatabase()
            {
                //A REDIGER
            }
        
    }       