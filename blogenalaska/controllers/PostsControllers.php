<?php
//namespace Forteroche\blogenalaska\Backend\BackendControllers;
// Chargement des classes
/*require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();*/

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/PdoConnection.php';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/ArticlesManager';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/Article';
require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/session/SessionClass';

//JE VAIS VERS MA PAGE ECRIRE UN ARTICLE
class PostsControllers
    {
        //Bouton écrire un article du menu pour afficher la page de redaction d'articles
        function writeAnArticle()
            {
                if (file_exists("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php"))
                    {
                        header('Location: /Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php');
                    }
                else
                    {
                        header('Location: /blogenalaska/views/Page404.php');
                    }
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

                                    $db = PdoConnection::connect();


                                    $sendToTheArticlesManager = new ArticlesManager($db);

                                    //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
                                    $sendToTheArticlesManager->add($newArticles);
                                    
                                    header('Location: /public/index.php?action=mainBackendPage');    
                                }
                            else 
                                {
                                    $session = new SessionClass();
                                    $session->setFlash('Les champs sont vides','error');
                                    
                                    if (file_exists("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php"))
                                        {
                                            require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php';
                                        }
                                    else
                                        {
                                            header('Location: /blogenalaska/views/Page404.php');
                                        }
                                }    
                        }
                    else
                        {
                            $session = new SessionClass();
                            $session->setFlash('Les champs ne sont pas remplis','error');
                                    
                            if (file_exists("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php"))
                                {
                                    require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php';
                                }
                            else
                                {
                                    header('Location: /blogenalaska/views/Page404.php');
                                }
                        }
            }
        
        //Je sauvegarde l'aricle sans le valider donc celui ci ne sera pas publié
        function saveNewArticle()
            {
                if (isset($_POST['content']) AND isset($_POST['title']) AND isset($_POST['image']) AND isset($_POST['save']))
                    {
                        if (!empty($_POST['content']) && !empty($_POST['title']) && !empty($_POST['image']) && !empty($_POST['save']))
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

                                $db = PdoConnection::connect();


                                $sendToTheArticlesManager = new ArticlesManager($db);

                                //Je vais vers la fonction add de ArticlesManager pour ajouter les données en basex
                                $sendToTheArticlesManager->save($newArticles);

                                header('Location: /public/index.php?action=mainBackendPage');
                            }
                        else
                            {
                                $session = new SessionClass();
                                $session->setFlash('Les champs sont vides','error');
                                
                                if (file_exists("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php"))
                                    {
                                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php';
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                            }
                    }
                else 
                    {
                        $session = new SessionClass();
                        $session->setFlash('Les champs ne sont pas remplis','error');

                        if (file_exists("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php"))
                            {
                                require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/WriteArticlesView.php';
                            }
                        else
                            {
                                header('Location: /blogenalaska/views/Page404.php');
                            }
                    }
            }
//FIN CREER UN NOUVEL ARTICLE
  
            
            
//ALLER VERS LA PAGE PRINCIPALE DU BACKEND
        //Récupérer la page principale du Backend
        function getMainBackendPage()
            {
                header('Location: /public/index.php?action=countArticles');
            }
//FIN ALLER VERS LA PAGE PRINCIPALE DU BACKEND
            
   
            
//COMPTER LES ARTICLES        
        //Fonction qui compte les articles
        function countArticles()
            {
                //Dans le cas ou si j'ai une erreur de déconnexion
                /*if (isset($_GET['error']))
                    {
                        if(!empty($_GET['error']))
                            {
                                $error = $_GET['error']; 
                            }
                        else
                            {

                            }
                        
                    }
                else
                    {

                    }*/
                $status = 'Valider';
                
                //Je vais compter mes articles en base de données    
                //$db = \Forteroche\blogenalaska\PdoConnection::connect();
                $database = new PdoConnection();
                $db = $database->connect();

                $articlesManager = new ArticlesManager($db);

                $articlesCount = $articlesManager->count();
                
                $numberOfArticlesPublished = $articlesManager->countPublishedArticles($status);

                if(empty($articlesCount) and (empty($numberOfArticlesPublished)))
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas de donnée disponible pour l\'instant','error');  
                    }
                    
                if (file_exists("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php"))
                    {
                        require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                    }
                else 
                    {
                        header('Location: /blogenalaska/views/Page404.php');
                    }
            }
//FIN COMPTER LES ARTICLES

            
            
//DATATABLES ARTICLES
        //Récupérer des articles de la base de données pour afficher au sein du datatables
        function getArticles()
            { 
                //$row = array();
                $db = PdoConnection::connect();

                $articlesManager = new ArticlesManager($db); 
                
                //ALler chercher les articles en bdd
                $articlesFromManager = $articlesManager->getList();//Appel d'une fonction de cet objet

                if (!empty ($articlesFromManager))
                    {
                        foreach ($articlesFromManager as $articles) 
                            {
                                $row = array();
                                $row[] = $articles->id();
                                $row[] = $articles->subject();

                                $row[] = $articles->createdate();

                                $updateArticleDate = $articles->updatedate();

                                if (is_null($updateArticleDate))
                                    {
                                        $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                                    }
                                else 
                                    {
                                        $row[] = $updateArticleDate;
                                    }
                                    
                                $row[] = $articles->status();
                                $data[] = $row;
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
                        if (file_exists("/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php"))
                            {
                                require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                            }
                        else 
                            {
                                header('Location: /blogenalaska/views/Page404.php');
                            }
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
                                $article = new Article
                                    ([

                                        'id' => $myIdArticle

                                    ]);

                                $db = PdoConnection::connect();

                                $articlesManager = new ArticlesManager($db);

                                $articlesManager->delete($article);
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article séléctionné','error');
                                
                                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                                    {
                                        require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                                    }
                                else 
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                            }
                    } 
                else 
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article séléctionné','error');

                        if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                            {
                                require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                            }
                        else 
                            {
                                header('Location: /blogenalaska/views/Page404.php');
                            }
                    }
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
                                $article = new Article
                                    ([
                                        'id' => $myIdArticle
                                    ]);

                                $db = PdoConnection::connect();

                                $articlesManager = new ArticlesManager($db);

                                $myArticlesToModify = $articlesManager->get($article);
                
                                if(!empty($myArticlesToModify))
                                    {
                                        $articleSubject = $myArticlesToModify->subject();
                                        $articleContent = $myArticlesToModify->content();
                                        $articleImage = $myArticlesToModify->image();
                                        $id = $myArticlesToModify->id();
                                        if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendViewFolders/ModifyArticlesView.php'))
                                            {
                                                require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendViewFolders/ModifyArticlesView.php';
                                            }
                                        else
                                            {
                                                header('Location: /blogenalaska/views/Page404.php');
                                            }
                                    }
                                else
                                    {
                                        $session = new SessionClass();
                                        $session->setFlash('pas d\'article trouvé','error');
                                        if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                                            {
                                                require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                                            }
                                        else
                                            {
                                                header('Location: /blogenalaska/views/Page404.php');
                                            }
                                    }
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article séléctionné','error');
                                
                                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                                    {
                                        require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                                    }
                                else 
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                            }
                    }
                else
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article trouvé','error');
                        
                        if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/viewss/BackendView.php'))
                            {
                                require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                            }
                        else
                            {
                                header('Location: /blogenalaska/views/Page404.php');
                            }
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
                                    
                                    $article = new Article
                                        ([
                                            'content' => $myContentOfArticle,
                                            'subject' => $myTitleOfArticle,
                                            'id' => $id,
                                            'image'=>$myImageOfArticle,
                                            'status' => $validate
                                        ]);

                                    $db = PdoConnection::connect();

                                    $articlesManager = new ArticlesManager($db);
                                    $articlesManager->update($article);
                                    header('Location: /public/index.php?action=mainBackendPage');
                                }
                            else 
                                {
                                    $session = new SessionClass();
                                    $session->setFlash('pas d\'article sélectionné','error');
                                    
                                    if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                                        {
                                            require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                                        }
                                    else
                                        {
                                            header('Location: /blogenalaska/views/Page404.php');
                                        }
                                }
                        } 
                    else
                        {
                            $session = new SessionClass();
                            $session->setFlash('pas d\'article sélectionné','error');

                            if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                                {
                                    require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                                }
                            else
                                {
                                    header('Location: /blogenalaska/views/Page404.php');
                                }
                        }
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
                                                                 
                                $article = new Article
                                    ([
                                        'content' => $myContentOfArticle,
                                        'subject' => $myTitleOfArticle,
                                        'id' => $id,
                                        'image'=>$myImageOfArticle,
                                        'status' => $save
                                    ]);

                                $db = PdoConnection::connect();

                                $articlesManager = new ArticlesManager($db);
                                $articlesManager->updateAndSave($article);
                                header('Location: /public/index.php?action=mainBackendPage');
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('pas d\'article sélectionné','error');
                                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                                    {
                                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                            }
                    }
                else 
                    {
                        $session = new SessionClass();
                        $session->setFlash('pas d\'article sélectionné','error');
                        if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php'))
                            {
                                require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/BackendView.php';
                            }
                        else
                            {
                                header('Location: /blogenalaska/views/Page404.php');
                            }
                    }
            }
//FIN MODIFIER UN ARTICLE
    }       