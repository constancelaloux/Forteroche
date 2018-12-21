<?php

// Chargement des classes
//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//Autoloader::register();

require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/Article.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Controllers/PdoConnection.php';

require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/ArticlesManager.php';

class PostsControllers
    {
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

                //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
                $sendToTheArticlesManager->add($newArticles);

            }

        //Fonction qui compte les articles
        function countArticles()
            {
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $articlesCount = $articlesManager->count();
                //print_r("je vais dans la function articlescount");
                return $articlesCount;
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
            }

        //Supprimer des articles en base de données
        function deleteArticles($myIdArticle)
            {

                $article = new Article
                    ([

                        'id' => $myIdArticle
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $articlesManager->delete($article);

            }

        //Modifier des données en base de données    
        function getArticlesFromId($myIdArticle)
            {
                $article = new Article
                    ([
                        'id' => $myIdArticle
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $myArticlesToModify = $articlesManager->get($article);

                $articleSubject = $myArticlesToModify->subject();
                $articleContent = $myArticlesToModify->content();
                return $articleContent;
                //return $articleSubject;
            }

        function update($myText, $myTitle)
            {
                $article = new Article
                    ([
                        'content' => $myText,
                        'subject' => $myTitle,
                        'id' => $id
                    ]);

                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);
                $articlesManager->update($article);
            }

        //Sauvegarder des données en base de données sans les afficher dans une vue   
        function saveArticlesIntoDatabase()
            {
                //A REDIGER
            }
            /*   $articles = new Article
                    ([
                        'content' => "",
                        'subject' => "",
                        'createdate' => new DateTime("")
                    ]); //Création d'un objet*/
    }       