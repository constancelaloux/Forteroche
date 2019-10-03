<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendControllers;
//namespace controllers;
// Chargement des classes
//require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//\Forteroche\blogenalaska\Autoloader::register();
//require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/frontend/FrontendModels/Search.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/PdoConnection.php';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/ArticlesManager.php';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/Article.php';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/session/SessionClass.php';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/controllers/CommentsController.php';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/SearchManager.php';

class BlogController 
    {
//RECUPERER PREMIERE PAGE DU FRONTEND
        //On va vers la premiére page du blog front
        function getTheMainFrontendBlogPage()
            { 
                header('Location: /public/index.php?action=iGetArticlesToshowInTheBlogPage');
            }
//FIN RECUPERER PREMIERE PAGE DU FRONTEND

            
            
//RECUPERER LA LISTE DES ARTICLES QUI SONT VALIDES
        //Fonction qui permet de récupérer les articles et de les afficher en premiére page du blog
        //Ainsi que le dernier article
        function getArticles()
            {
                //Je récupére mes articles
                $db = PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                
                
                if (empty($articlesManager))
                    {
                        //$this->app->httpResponse()->redirect404();
                        //require_once 'Frontend/FrontendViews/HomePage.php';
                        if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/HomePage.php'))
                            {
                                require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/HomePage.php';
                            }
                        else
                            {
                                header('Location: /blogenalaska/Error/Page404.php');
                            }
                    }

                else 
                    {
                        //On récupére le nombre d'articles total en bdd
                        $nbrArticles = $articlesManager->count();
                        //Combien d'articles souhaite t'on par page
                        $nbrArticlesPerPage = 5;
                        //$nbrArticles = $countArticlesFromManager;
                        if(!empty($nbrArticles))
                            {
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
                             
                                $status = 'Valider'; 
                                
                                //Je récupére tous les articles
                                $articlesFromManager = $articlesManager->getListOfFiveArticles($page,$nbrArticlesPerPage, $status);
                                if(empty($articlesFromManager))
                                    {
                                        $session = new SessionClass();
                                        $session->setFlash('impossible d\'afficher les articles','error');
                                    }
                                //Je récupére mon dernier article en bdd
                                $lastArticle = $articlesManager->getUnique($status);//Appel d'une fonction de cet objet
                                if(empty($lastArticle))
                                    {
                                        $session = new SessionClass();
                                        $session->setFlash('impossible d\'afficher les articles','error');
                                    }
                                    
                                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/HomePage.php'))
                                    {
                                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/HomePage.php';
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                                //require_once 'Frontend/FrontendViews/HomePage.php';
                            }
                        else 
                           {
                                $session = new SessionClass();
                                $session->setFlash('impossible d\'afficher les articles','error');
                                
                                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/HomePage.php'))
                                    {
                                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/HomePage.php';
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                           }
                    }
            }
//FIN RECUPERER LA LISTE DES ARTICLES QUI SONT VALIDES

            
            
//JE RECUPERE L'ARTICLE EN FN DE L'ID          
        //Obtenir l'intégralité de l'article en fonction de l'id 
        //pour l'afficher lorsque l'on clique sur le lien lire la suite
        function getTheArticleFromId()
            {
                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
                                $myIdArticle = $_GET['id'];
                                $article = new Article
                                ([

                                    'id' => $myIdArticle

                                ]);

                                $db = PdoConnection::connect();

                                $articlesManager = new ArticlesManager($db);
                                if(empty($articlesManager))
                                    {
                                        $session = new SessionClass();
                                        $session->setFlash('impossible d\'afficher l\'article','error');
                                    }
                                else
                                    {
                                        $myArticle = $articlesManager->get($article);
                                        $titleToDisplay = $myArticle->subject();
                                        $articlesToDisplay = $myArticle->content();
                                  
                                        $imageToDisplay = $myArticle->image();
                                    }
                
                                $comment = new CommentsController();
                                $numberOfComments = $comment->countComments();
                                $myComment = $comment->getListOfComments();
                                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/MyArticles.php'))
                                    {
                                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/MyArticles.php';
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                                //require_once 'Frontend/FrontendViews/Articles/MyArticles.php';
                            }
                        else 
                            {
                                //echo 'pas d article séléctionné';
                                $session = new SessionClass();
                                $session->setFlash('pas d article séléctionné','error');
                            }
                    }
            }
//FIN JE RECUPERE L'ARTICLE EN FN DE L'ID  
            
            

//JE RECHERCHE UN ARTICLE DANS LE BLOG            
        function search()
            {
                if (isset($_POST['whatImSearching']))
                    {
                        if (!empty($_POST['whatImSearching']))
                            {
                                $mySearchWords = $_POST['whatImSearching'];
                                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                                $searchManager = new SearchManager($db);

                                $mySearchResult = $searchManager->get($mySearchWords);
                                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/ResultSearchPage.php'))
                                    {
                                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/ResultSearchPage.php';
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                                //require_once 'Frontend/FrontendViews/ResultSearchPage.php';
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('Vous n\'avez pas fait de recherche','error');
                                //echo 'Vous n\'avez rien recherché';
                            }
                    }
                else
                    {
                        $session = new SessionClass();
                        $session->setFlash('Vous n\'avez pas fait de recherche','error');
                    }
                    
                /*$words = new Search
                    ([

                        'mySearchWords' => $mySearchWords

                    ]);*/
                //print_r($_POST['whatImSearching']);
                //print_r($words);
            }
//FIN JE RECHERCHE UN ARTICLE DANS LE BLOG
            
    }
