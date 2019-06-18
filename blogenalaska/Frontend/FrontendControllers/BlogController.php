<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendControllers;
// Chargement des classes
require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();
//require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/frontend/FrontendModels/Search.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';

//require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/frontend/FrontendModels/SearchManager.php';

class BlogController 
    {
        //On va vers la premiére page du blog front
        function getTheMainFrontendBlogPage()
            { 
                header('Location: /blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage');
            }
        
        //Fonction qui permet de récupérer les articles et de les afficher en premiére page du blog
        //Ainsi que le dernier article
        function getArticles()
            {
                //Je récupére mes articles
                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                
                
                if (empty($articlesManager))
                    {
                        //$this->app->httpResponse()->redirect404();
                        require_once 'Frontend/FrontendViews/HomePage.php';
                    }

                else 
                    {
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
                       
                         
                        require_once 'Frontend/FrontendViews/HomePage.php';
                    }
            }
            
        //Obtenir l'intégralité de l'article en fonction de l'id 
        //pour l'afficher lorsque l'on clique sur le lien lire la suite
        function getTheArticleFromId()
            {
                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
                                $myIdArticle = $_GET['id'];
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

                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $myArticle = $articlesManager->get($article);
                $titleToDisplay = $myArticle->subject();
                $articlesToDisplay = $myArticle->content();
                $imageToDisplay = $myArticle->image();
                
                $comment = new CommentsController();
                $numberOfComments = $comment->countComments();
                $myComment = $comment->getListOfComments();
                
                require_once 'Frontend/FrontendViews/Articles/MyArticles.php';
            }
        
        function search()
            {
                if (isset($_POST['whatImSearching']))
                    {
                        if (!empty($_POST['whatImSearching']))
                            {
                                $mySearchWords = $_POST['whatImSearching'];
                            }
                        else 
                            {
                                echo 'Vous n\'avez rien recherché';
                            }
                    }
                    
                /*$words = new Search
                    ([

                        'mySearchWords' => $mySearchWords

                    ]);*/
                //print_r($_POST['whatImSearching']);
                //print_r($words);
                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $searchManager = new SearchManager($db);

                $mySearchResult = $searchManager->get($mySearchWords);

                //print_r("je récup le resultat");
                //print_r($mySearchResult = $searchManager->get($mySearchWords));
                
                //die("je ne continue pas");
                require_once 'Frontend/FrontendViews/ResultSearchPage.php';
            }
            
    }
