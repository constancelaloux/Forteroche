<?php

class BlogController 
    {
        //On va vers la premiére page du blog front
        function getTheMainFrontendBlogPage()
            {
                header('Location: /blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage');
                //require 'Frontend/FrontendViews/HomePage.php';
            }
        
        //Fonction qui va vers la page des articles du blog
        function getTheArticleBlogPage()
            {
                header('Location: /blogenalaska/Frontend/frontendViews/Articles/MyArticles.php');
            }
        
        //Fonction qui va vers  la page contact du blog
        function myContactViewPage()
            {
                header('Location: /blogenalaska/Frontend/frontendViews/Contact.php');
            }
        
        //Fonction qui permet de récupérer les articles et de les afficher en premiére page du blog
        function getArticles()
            {
            //print_r("je vais vers cette fonction get articles");
                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                //ALler chercher les articles en bdd
                $articlesFromManager = $articlesManager->getList(0, 5);//Appel d'une fonction de cet objet    

                /*foreach ($articlesFromManager as $articles) 
                    {
                        $titlesToDisplay[] = $articles->subject();
                        $articlesToDisplay[] = $articles->content();
                        //$row = array();
                        
                        //$row[] = $articles->content();
                        //$row[] = $articles->id();
                       /* if ($articles->content())
                            {
                            //print_r($articles->content());
                                $row[] = $articles->content();
                                //exit();
                            }*/
                   /* }*/
                    
                require 'Frontend/FrontendViews/HomePage.php';
            }
    }
