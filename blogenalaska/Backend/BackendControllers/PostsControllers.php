<?php

// Chargement des classes
//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//Autoloader::register();

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/Article.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/ArticlesManager.php';

require_once"/Applications/MAMP/htdocs/Forteroche/blogenalaska/Session/SessionClass.php";

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
                if (isset($_POST['content']) AND isset($_POST['title']) AND isset($_POST['validate']))
                        {
                            if (!empty($_POST['content']) && !empty($_POST['title']) && !empty($_POST['image']) && !empty($_POST['validate']))
                                {
                                    $myText = $_POST['content'];

                                    $myTitle = $_POST['title'];

                                    $myImg = $_POST['image'];
                                    
                                    $status = $_POST['validate'];

                                    $newArticles = new Article
                                        ([
                                            'subject' => $myTitle,
                                            'content' => $myText,
                                            'image' => $myImg,
                                            'status' => $status
                                        ]);

                                    $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();


                                    $sendToTheArticlesManager = new ArticlesManager($db);

                                    //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
                                    $sendToTheArticlesManager->add($newArticles);

                                    header('Location: /blogenalaska/index.php?action=mainBackendPage');
                                }
                            else 
                                {
                                    $session = new SessionClass();
                                    $session->setFlash('Les champs ne sont pas remplis','error');
                                    //header('Location: /blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php');
                                    require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php';
                                    //header('Location: /blogenalaska/index.php?action=writeAnArticle');
                                }
                        }
            }
        
        //Je sauvegarde l'aricle sans le valider donc celui ci ne sera pas publié
        function saveNewArticle()
            {
                if (isset($_POST['content']) AND isset($_POST['title']) AND isset($_POST['image']) AND isset($_POST['save']))
                    {
                        $myText = $_POST['content'];

                        $myTitle = $_POST['title'];

                        $myImg = $_POST['image'];
                         
                        $status = $_POST['save'];

                        $newArticles = new Article
                            ([
                                'subject' => $myTitle,
                                'content' => $myText,
                                'image' => $myImg,
                                'status'=>$status
                            ]);

                        $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();


                        $sendToTheArticlesManager = new ArticlesManager($db);

                        //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
                        $sendToTheArticlesManager->save($newArticles);

                        header('Location: /blogenalaska/index.php?action=mainBackendPage');
                    }
            }
        
        //Récupérer la page principale du Backend
        function getMainBackendPage()
            {
                header('Location: /blogenalaska/index.php?action=countArticles');
            }
            
        //Fonction qui compte les articles
        function countArticles()
            {
                //Dans le cas ou si j'ai une erreur de déconnexion
                if (isset($_GET['error']))
                    {
                        $error = $_GET['error'];
                    }
                //Je vais compter mes articles en base de données    
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $articlesCount = $articlesManager->count();

                if(!isset($articlesCount))
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas de donnée disponible pour l\'instant','error');  
                    }
                require 'Backend/BackendViews/BackendViewFolders/BackendView.php';
            }

        //Récupérer des articles de la base de données pour afficher au sein du datatables
        function getArticles()
            { 
                //$row = array();
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                
                //ALler chercher les articles en bdd
                $articlesFromManager = $articlesManager->getList();//Appel d'une fonction de cet objet
                
                if (!empty ($articlesFromManager))
                    {
                        foreach ($articlesFromManager as $articles) 
                            {
                                $row = array();
                                $row[] = $articles->id();
                                $row[] = $articles->subject();

                                $row[] = $articles->createdate();
                                //$row[] =$articleDate;//->format('Y-m-d');

                                $updateArticleDate = $articles->updatedate();

                                if (is_null($updateArticleDate))
                                    {
                                        $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                                    }
                                else 
                                    {
                                        $row[] = $updateArticleDate;//->format('Y-m-d');
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
                else
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas de donnée disponible pour l\'instant','error');
                    }
            }
        
            
        //Supprimer des articles en base de données
        function deleteArticles()
            {
                if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                                // check if the id has been set
                                $myIdArticle = $_POST['id'];
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article séléctionné','error');
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
                                $myIdArticle = $_GET['id'];
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article séléctionné','error');
                            }
                    }
            
                $article = new Article
                    ([
                        'id' => $myIdArticle
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $myArticlesToModify = $articlesManager->get($article);
                
                if(!empty($myArticlesToModify))
                    {
                        $articleSubject = $myArticlesToModify->subject();
                        $articleContent = $myArticlesToModify->content();
                        $articleImage = $myArticlesToModify->image();
                        $id = $myArticlesToModify->id();

                        require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/BackendViewFolders/ModifyArticlesView.php';
                    }
                else
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article trouvé','error');
                        require'/Backend/BackendViews/BackendViewFolders/BackendView.php';
                    }
            }
        
        //Modifier les données de l'article en base de données apres validation
        function update()
            {
                if (isset($_POST['id']))
                        {
                            if (!empty($_POST['id']))
                                {
                                    // check if the id has been set
                                    $id = $_POST['id'];
                                    $myContentOfArticle = $_POST['content'];
                                    $myTitleOfArticle = $_POST['title'];
                                    $myImageOfArticle = $_POST['image'];
                                    $validate =  $_POST['validate'];
                                }
                            else 
                                {
                                    $session = new SessionClass();
                                    $session->setFlash('pas d\'article sélectionné','error');
                                    require'/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php';
                                }
                        } 
                        
                $article = new Article
                    ([
                        'content' => $myContentOfArticle,
                        'subject' => $myTitleOfArticle,
                        'id' => $id,
                        'image'=>$myImageOfArticle,
                        'status' => $validate
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);
                $articlesManager->update($article);
                header('Location: /blogenalaska/index.php?action=mainBackendPage');
            }
            
        //Modifier les données de l'article en base de données apres validation
        function saveArticleFromUpdate()
            {
                if (isset($_POST['id']))
                        {
                            if (!empty($_POST['id']))
                                {
                                    // check if the id has been set
                                    $id = $_POST['id'];
                                    $myContentOfArticle = $_POST['content'];
                                    $myTitleOfArticle = $_POST['title'];
                                    $myImageOfArticle = $_POST['image'];
                                    $save =  $_POST['save'];
                                }
                            else 
                                {
                                    $session = new SessionClass();
                                    $session->setFlash('pas d\'article sélectionné','error');
                                    require'/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php';
                                }
                        } 
                        
                $article = new Article
                    ([
                        'content' => $myContentOfArticle,
                        'subject' => $myTitleOfArticle,
                        'id' => $id,
                        'image'=>$myImageOfArticle,
                        'status' => $save
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);
                $articlesManager->updateAndSave($article);
                header('Location: /blogenalaska/index.php?action=mainBackendPage');
            }
    }       