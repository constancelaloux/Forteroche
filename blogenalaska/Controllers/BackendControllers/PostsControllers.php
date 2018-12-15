<?php

// Chargement des classes
//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//Autoloader::register();
//require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/Article.php';

require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Controllers/PdoConnection.php';

//require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/ArticlesManager.php';


//Envoyer des articles en base de données
function transferArticlesToModel($myText, $myTitle)
    {
        //print_r($myText);
        $newArticles = new Article
            ([
                'content' => $myText,
                'subject' => $myTitle
            ]);
        
        //Je me connecte
        $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();
        

        $sendToTheArticlesManager = new ArticlesManager($db);
        
        //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
        $sendToTheArticlesManager->add($newArticles);
        
        if ($sendToTheArticlesManager == true)
            {
                //print_r("Je retourne vers la page d'accueil");
                //header('Location: http://localhost:8888/Forteroche/blogenalaska/index.php?action=redirectionGetArticles');
                //header('Location: http://localhost:8888/Forteroche/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php');
                redirectionGetArticles();
                //require '/Forteroche/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php';
            }
        else 
            {
                print_r("erreur, l'article n'a pas pu étre envoyé!");
                require '/Forteroche/blogenalaska/Views/Backend/BackendViewFolders/WriteArticlesView.php';
            }
    }
    

//Récupérer des articles de la base de données
function getArticles()
    {    
     /*   $articles = new Article
            ([
                'content' => "",
                'subject' => "",
                'createdate' => new DateTime("")
            ]); //Création d'un objet*/
        
        $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

        $articlesManager = new ArticlesManager($db);
        //print_r($articlesManager);
        $articlesFromManager = $articlesManager->getList();//($articles);// Appel d'une fonction de cet objet
        //print_r($articlesFromManager);
        //var_dump($articlesFromManager = $articlesManager->getList($articles));
        //var_dump($articlesFromManager);
        
        foreach ($articlesFromManager as $articles) 
            {
                $row = array();
                $row[] = $articles->id();
                $row[] = $articles->subject();
                $row[] = $articles->content();
                
                $articleDate = $articles->createdate();
                $row[] =$articleDate->format('Y-m-d');
                
                $updateArticleDate = $articles->updatedate();
                $row[] =$updateArticleDate->format('Y-m-d');
                
                $data[] = $row;
            }
        // Structure des données à retourner
        $json_data = array
            (
                "data" => $data
            );
        
        echo json_encode($json_data);
        return $json_data;
        
    }

//Supprimer des articles en base de données
function deleteArticles($myIdArticle)
    {
        //print_r($myIdArticle);
        //print_r("je vais supprimer les données");
        //exit("je sors");
        /*$data = array
                (
                    'id' => $myIdArticle
                );
        print_r($data);*/
        
        $article = new Article
            ([
                
                'id' => $myIdArticle
            ]);
        //print_r("je rentre dans la fonction connect");
        $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

        $articlesManager = new ArticlesManager($db);
        
        $articlesManager->delete($article);
        
        if ($articlesManager == true)
        {
            redirectionGetArticles();
        }
    }

//Modifier des données en base de données    
/*function updateArticles($myIdArticle)
    {
        print_r("je vais modifier les données");
        $modifyIdArticle = new Article;
            ([
                'id' => $myIdArticle
            ]);
        $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

        $articlesManager = new ArticlesManager($db);
        
        $articlesManager->update($modifyIdArticle);
    }*/