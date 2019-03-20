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
                //echo"je rentre dans la fonction écrire un article";
                header('Location: /blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php');
                //require '/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php';
            }
            /*   $articles = new Article
                    ([
                        'content' => "",
                        'subject' => "",
                        'createdate' => new DateTime("")
                    ]); //Création d'un objet*/
            
        //Envoyer des articles en base de données
        function createNewArticle()
            {       
            print_r($_POST['content']);
            print_r($_POST['title']);
            print_r($_POST['image']);
            exit("je sors");
                if (isset($_POST['content']) AND isset($_POST['title']) AND isset($_POST['img']))
                        {
                            if (!empty($_POST['content']) && !empty($_POST['title']) && !empty($_POST['img']))
                                {
                                    $myText = ($_POST['content']);
                 

                                    $myTitle = ($_POST['title']);

                                    $myImg = ($_POST['img']);
                                    //$date = NULL;
                                    //require '/blogenalaska/Backend/BackendViewFolders/BackendView.php';
                                    //header('Location: /blogenalaska/index.php?action=mainBackendPage');
                                }
                            else 
                                {
                                    // On fait un écho si les variables sont vides
                                    //echo('Les champs ne sont pas remplis');
                                    require'/Forteroche/blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php';
                                //header('Location: /blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php');
                                    
                                } 
                        }
                    
                $newArticles = new Article
                    ([
                        'subject' => $myTitle,
                        'content' => $myText,
                        'image' => $myImg
                        //'updatedate' => $date
                        
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
                //return $articlesCount;
                //print_r($articlesCount);
                //return $articlesCount;
                require 'Backend/BackendViews/BackendViewFolders/BackendView.php';
                //header('Location: Backend/BackendViews/BackendViewFolders/BackendView.php');
                ////header('Location: Views/Backend/BackendViewFolders/BackendView.php');
                //require 'Views/Backend/BackendViewFolders/BackendView.php';
                
                //print_r($articlesCount);
                //print_r("je vais dans la function articlescount");
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
                        //$row[] = $articles->content();

                        $articleDate = $articles->createdate();
                        $row[] =$articleDate->format('Y-m-d');

                        $updateArticleDate = $articles->updatedate();
                        //print_r($updateArticleDate);
                        if (is_null($updateArticleDate))
                            {
                                $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                                //echo"on y est";
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
                        //require 'Backend/BackendViews/BackendViewFolders/BackendView.php';
            }
        
            
        //Supprimer des articles en base de données
        function deleteArticles()
            {
                //print_r("je vais dans le controller");
               // exit("je sors");
                //if ($_GET['action'] === 'removeArticles?id=id')
                //{
                //print_r("je passe dans l'index");
                //print_r($_POST['id']);
                //exit("je sors");
                if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                            //print_r("j'y suis");
                                // check if the id has been set
                                $myIdArticle = ($_POST['id']);
                                //print_r($myIdArticle);
                                //deleteArticles($myIdArticle);
                                //require'Views/Backend/BackendViewFolders/BackendView.php';
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                require'/Backend/BackendViews/BackendViewFolders/BackendView.php';
                            }
                    } 
                //} 
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

                                //$articleSubject = getArticlesFromId($myIdArticle);
                               
                                //print_r($myIdArticle);
                                
                                //('Location: index.php?action=post');
                                //require'Views/Backend/BackendViewFolders/ModifyArticlesView.php';
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                //require'/Backend/BackendViews/BackendViewFolders/BackendView.php';
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
                
                //print_r($articleContent);
                $id = $myArticlesToModify->id();
                //require '/Backend/BackendViews/BackendViewFolders/.php';
                //header('Location:/blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php');
                //echo json_encode($articleSubject);
                require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/BackendViewFolders/ModifyArticlesView.php';
                //print_r('j\'y suis');
                //exit("je sors");
                //header('Location:/blogenalaska/Backend/BackendViews/BackendViewFolders/ModifyArticlesView.php');
                //header('Location:/blogenalaska/index.php?action=test');
                ////return $articleContent;
                //return $articleSubject;
            }
        
        //Modifier les données de l'article en base de données apres validation
        function update()
            {
                //print_r(($_POST['content']));
                //print_r(($_POST['id']));

                //exit("je sors");
                if (isset($_POST['id']))
                        {
                            if (!empty($_POST['id']))
                                {

                                    // check if the id has been set
                                    $id = ($_POST['id']);
                                    $myContentOfArticle = ($_POST['content']);
                                    $myTitleOfArticle = ($_POST['title']);

                                    //$articleSubject = getArticlesFromId($myIdArticle);

                                    //print_r($articleSubject);
                                    //exit("je sors");
                                    //('Location: index.php?action=post');
                                    //require'Views/Backend/BackendViewFolders/ModifyArticlesView.php';
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
        
                
        /*function buttonGetMainPage()
            {
                header('Location: Views/Backend/BackendViewFolders/BackendView.php');
            }*/
        

    }       