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
        $newArticles = new Article
            ([
                'content' => $myText,
                'subject' => $myTitle
            ]);

        $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

        $sendToTheArticlesManager = new ArticlesManager($db);

        $sendToTheArticlesManager->add($newArticles);
        
        if ($sendToTheArticlesManager == true)
            {
                header('Location: /blogenalaska/index.php?action=test');
                //redirectionVueAdmin(); 

            }
        else 
            {
                print_r("erreur");
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

function deleteArticles()
    {
        print_r("je vais supprimer les données");
    }