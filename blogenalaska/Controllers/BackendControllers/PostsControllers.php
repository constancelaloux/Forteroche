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
    }

//Récupérer des articles de la base de données
function getArticles()
    {
        print_r("je suis dans le controller");
        $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();
        print_r("je récupére des données");
        $articlesManager = new ArticlesManager($db);
        $articlesFromManager = $articlesManager->verify(); // Appel d'une fonction de cet objet
        //$articlesFromDb = $articlesFromManager->subject();
    }

