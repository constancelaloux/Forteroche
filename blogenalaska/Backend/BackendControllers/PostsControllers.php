<?php
//namespace Forteroche\blogenalaska\Backend\BackendControllers;
// Chargement des classes
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';

//require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/Article.php';
/*require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/ArticlesManager.php';

require_once"/Applications/MAMP/htdocs/Forteroche/blogenalaska/Session/SessionClass.php";*/

//JE VAIS VERS MA PAGE ECRIRE UN ARTICLE
class PostsControllers
    {
        //Bouton écrire un article du menu pour afficher la page de redaction d'articles
        function writeAnArticle()
            {
                header('Location: /blogenalaska/Backend/BackendViews/BackendViewFolders/WriteArticlesView.php');
            }
//FIN PAGE ECRIRE UN ARTICLE

            
            
//JE CREE UN NOUVEL ARTICLE
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

                                    $db = \Forteroche\blogenalaska\PdoConnection::connect();


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

                        $db = \Forteroche\blogenalaska\PdoConnection::connect();


                        $sendToTheArticlesManager = new ArticlesManager($db);

                        //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
                        $sendToTheArticlesManager->save($newArticles);

                        header('Location: /blogenalaska/index.php?action=mainBackendPage');
                    }
            }
//FIN CREER UN NOUVEL ARTICLE
  
            
            
//ALLER VERS LA PAGE PRINCIPALE DU BACKEND
        //Récupérer la page principale du Backend
        function getMainBackendPage()
            {
                header('Location: /blogenalaska/index.php?action=countArticles');
            }
//FIN ALLER VERS LA PAGE PRINCIPALE DU BACKEND
            
   
            
//COMPTER LES ARTICLES        
        //Fonction qui compte les articles
        function countArticles()
            {
                //Dans le cas ou si j'ai une erreur de déconnexion
                if (isset($_GET['error']))
                    {
                        $error = $_GET['error'];
                    }
                $status = 'Valider';
                
                //Je vais compter mes articles en base de données    
                //$db = \Forteroche\blogenalaska\PdoConnection::connect();
                $database = new \Forteroche\blogenalaska\PdoConnection();
                $db = $database->connect();

                $articlesManager = new ArticlesManager($db);

                $articlesCount = $articlesManager->count();
                
                $numberOfArticlesPublished = $articlesManager->countPublishedArticles($status);

                if(!isset($articlesCount) and (!isset($numberOfArticlesPublished)))
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas de donnée disponible pour l\'instant','error');  
                    }
                require_once 'Backend/BackendViews/BackendViewFolders/BackendView.php';
            }
//FIN COMPTER LES ARTICLES

            
            
//DATATABLES ARTICLES
        //Récupérer des articles de la base de données pour afficher au sein du datatables
        function getArticles()
            { 
                //$row = array();
                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                
                //ALler chercher les articles en bdd
                $articlesFromManager = $articlesManager->getList();//Appel d'une fonction de cet objet
                //print_r($articlesFromManager);
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
                                $row[] = $articles->status();
                                $data[] = $row;
                                
                                //die('je sors');
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
//FIN DATATABLES ARTICLES      
  
            
            
//SUPPRIMER ARTICLES
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
                                require_once '/Backend/BackendViews/BackendViewFolders/BackendView.php';
                            }
                    }  
                $article = new Article
                    ([

                        'id' => $myIdArticle

                    ]);

                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $articlesManager->delete($article);
            }
//FIN SUPPRIMER ARTICLES

            
//MODIFIER UN ARTICLE
        //Aller réupérer le titre, l'article et l'image en base de données    
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

                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);

                $myArticlesToModify = $articlesManager->get($article);
                
                if(!empty($myArticlesToModify))
                    {
                        $articleSubject = $myArticlesToModify->subject();
                        $articleContent = $myArticlesToModify->content();
                        $articleImage = $myArticlesToModify->image();
                        $id = $myArticlesToModify->id();

                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/BackendViewFolders/ModifyArticlesView.php';
                    }
                else
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article trouvé','error');
                        require_once'/Backend/BackendViews/BackendViewFolders/BackendView.php';
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
                                    require_once'/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php';
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

                $db = \Forteroche\blogenalaska\PdoConnection::connect();

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
                                    require_once'/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php';
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

                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $articlesManager = new ArticlesManager($db);
                $articlesManager->updateAndSave($article);
                header('Location: /blogenalaska/index.php?action=mainBackendPage');
            }
//FIN MODIFIER UN ARTICLE
    }       