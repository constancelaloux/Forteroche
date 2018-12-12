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
                $row[] = $articles->subject();
                $row[] = $articles->content();
                $articleDate = $articles->createdate();
                $row[] =$articleDate->format('Y-m-d');
                
                $data[] = $row;
            }
        // Structure des données à retourner
        $json_data = array(
            "data" => $data
                /*$date = new DateTime($articles->createdate());
        $row[] =$date->format('d/m/y');*/


        /*$myDate[] = $articles->createdate();
            //foreach ($myDate as $key=>$value) 
            foreach ($myDate as $value) 
                {
               //print_r($myDate);
                    $row[] = $value;
                    //$row[] = $key['date'];

                //print_r($row);
                }*/
        );
        
        echo json_encode($json_data);
        /*foreach ($articlesFromManager as $value) 
            {
                //var_dump($value);
                $subjectArticles = $value->subject();
                $contentArticles = $value->content();
                //print_r($contentArticles);
                $json_data = array
                    (
                        "data" => [$subjectArticles],
                       // "data" => [$subjectArticles, $contentArticles],[$subjectArticles, $contentArticles]
                        "content" => [$contentArticles]
                        //"date" => $dateArticles    
                    );
        
                echo json_encode($json_data);
            }*/
        /*$subjectArticles = $articlesFromManager->subject();
        $contentArticles = $articlesFromManager->content();
        //$dateArticles =  $articlesFromManager->createdate();*/
       
       /* $json_data = array(
            "data" => $subjectArticles,
           // "data" => [$subjectArticles, $contentArticles],[$subjectArticles, $contentArticles]
            "content" => $contentArticles
            //"date" => $dateArticles    
            );
        
        echo json_encode($json_data);*/
        //print_r($json_data);
        //return json_encode($json_data);
        return $json_data;
        
    }

