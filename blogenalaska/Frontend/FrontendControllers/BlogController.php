<?php

class BlogController 
    {
        //On va vers la premiére page du blog front
        function getTheMainFrontendBlogPage()
            { 
                header('Location: /blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage');
            }
        
        //Fonction qui permet de récupérer les articles et de les afficher en premiére page du blog
        function getArticles()
            {
                //Je récupére mes articles
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                
                //On récupére le nombre d'articles total en bdd
                $countArticlesFromManager = $articlesManager->count();
                $nbrArticles = $countArticlesFromManager;
                
                //Combien d'articles souhaite t'on par page
                $nbrArticlesPerPage = 5;

                $numberOfPages = ceil($nbrArticles/$nbrArticlesPerPage);
                
                if (isset($_GET['p']))
                    {
                        $page = $_GET['p'];

                        $nextpage = $page + 1;

                        $prevpage = $page - 1;
                        
                        if($prevpage  < 1)
                            {
                                $prevpage = $numberOfPages;
                            }
                        
                        if($nextpage > $numberOfPages)
                            {
                                $nextpage = 1;
                            }
                    } 
                else
                    {
                        $page = 1;
                    }
                
                $articlesFromManager = $articlesManager->getListOfFiveArticles($page,$nbrArticlesPerPage);
   
                //Je récupére mon dernier article en bdd
                $lastArticle = $articlesManager->getUnique();//Appel d'une fonction de cet objet
                
                $titleLastArticle = $lastArticle->subject();
                $contentLastArticle = $lastArticle->content();
                $imageLastArticle = $lastArticle->image();
                require 'Frontend/FrontendViews/HomePage.php';
            }
            
        //Obtenir l'intégralité de l'article en fonction de l'id 
        //pour l'afficher lorsque l'on clique sur le lien lire la suite
        function getTheArticleFromId()
            {

                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
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

                $myArticle = $articlesManager->get($article);
                $titleToDisplay = $myArticle->subject();
                $articlesToDisplay = $myArticle->content();
                $imageToDisplay = $myArticle->image();
                
                $comment = new CommentsController();
                $myComment = $comment->getListOfComments();
                
                require 'Frontend/FrontendViews/Articles/MyArticles.php';
            }
        

        
        //Je récupére le dernier article pour l'afficher sur le blog
        /*function getUniqueArticle()
            {
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                //ALler chercher les articles en bdd
                $articlesFromManager = $articlesManager->getUnique();//Appel d'une fonction de cet objet
                //print_r($articlesFromManager);
                
                $title = $articlesFromManager->subject();
                $content = $articlesFromManager->content();
                
                require 'Frontend/FrontendViews/HomePage.php';
            }*/
            
    }
