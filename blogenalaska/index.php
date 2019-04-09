<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Chargement des classes
//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//Autoloader::register();
//Backend
require_once'Backend/BackendControllers/FormAuthorAccessControler.php';
require_once'Backend/BackendControllers/PostsControllers.php';
//require_once'Backend/BackendControllers/doLogout.php';
require_once 'Backend/BackendControllers/upload.php';

//Frontend
require_once 'Frontend/FrontendControllers/BlogController.php';
require_once 'Frontend/FrontendControllers/CommentsController.php';

//Si j'ai une action ou sinon action par default

    (isset($_GET['action'])) ? $action = $_GET['action'] : $action = "getTheFormAdminConnexionBackend";

                switch ($action)
                    {
//BACKEND
                        //Je vais vers le formulaire qui permet de créer un admin
                        case 'createNewAdminForm':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->getFormToCreateNewAdmin();    
                        break;
                    
                        //Je créé un nouvel admin
                        case 'createPasswordAndUsername':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->createNewAdmin();
                        break; 
                    
                        //Je vais vers mon formulaire de connexion au backend
                        case 'getTheFormAdminConnexionBackend':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->getTheFormAdminConnexionBackend();
                        break;
                    
                        //Je check le mot de passe et l'username
                        case 'checkThePassAndUsername':                
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->checkThePassAndUsername();
                        break;
                    
                        //Je compte les articles
                        case 'countArticles':
                            //print_r("je suis dans le router");
                            //$postsController = new PostsControllers();
                            //$articles = $postsController->countArticles();  
                            $postsController = new PostsControllers();
                            //$articlesCount = $postsController->countArticles();
                            $articlesCount = $postsController->countArticles();
                            //print_r($articlesCount);
                        break;
                    
                        //Je récupére les articles au sein du datatables
                        case 'getArticlesIntoDatatables':
                            $postsController = new PostsControllers();
                            $postsController->getArticles();
                            //print_r("je suis dans le router");
                       break; 
                   
                        //Je suuprime un article
                        case 'removeArticles':
                            $postsController = new PostsControllers();
                            $postsController->deleteArticles();
                        break; 
                    
                        //J'écris un article
                        case 'writeAnArticle':
                            $postsController = new PostsControllers();     
                            $postsController->writeAnArticle();
                        break;
                        
                        //J'envoi mon article en base de donnée
                        case 'saveNewArticle':
                            //exit('je sors');
                            $postsController = new PostsControllers();     
                            $postsController->createNewArticle();
                        break;
                        
                        //Je reviens à la page principale du backend
                        case 'mainBackendPage':
                            $postsController = new PostsControllers();
                            $postsController->getMainBackendPage();
                        break;
                    
                        //Je veux modifier mon article alors je récupére l'article en fonction de l'id
                        //Et je vais l'afficher dans mon éditeur d'articles
                        case 'updateArticles':
                            $postsController = new PostsControllers();
                            $postsController->getArticlesFromId();
                            //$articleContent = $postsController->getArticlesFromId();
                        break;
                    
                        case 'articleUpdated':
                            $postsController = new PostsControllers();
                            $postsController->update(); 
                        break;
                        
                        //Bouton de déconnexion
                        case 'disconnectTheAdmin':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->disconnect();
                        break;
                        
                        // Je télécharge une image pour l'insérer dans mon article
                        case 'uploadImage':
                            $uploadController = new UploadControler();
                            $uploadController->upload();
                        break;
                    
                        case 'iGetImageIntoFormFromUploadPath':
                            //print_r("je suis dans le routeur");
                            $uploadController = new UploadControler();
                            $uploadController->upload2();
                        break;   

//FRONTEND              
                        //Je vais vers la page d'accueil de mon blog
                        case 'goToFrontPageOfTheBlog':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getTheMainFrontendBlogPage();
                        break;
                      
                        //J'affiche les articles sur la premiére page du blo
                        case 'iGetArticlesToshowInTheBlogPage':
                            //print_r("j y suis");
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getArticles();
                        break;
                    
                        //J'ai récupéré l'id de l'article et je vais afficher l'article en entier et les commentaires de cet article
                        case 'getArticleFromId':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getTheArticleFromId();
                            //$commentsController = new CommentsController();
                            //$commentsController->getListOfComments();
                        break;
                        
                        //Je récupére les commentaires pour les afficher sur la page
                        /*case 'iGetCommentsToshowInTheBlogPage':
                            $commentsController = new CommentsController();
                            $commentsController->getListOfComments(); 
                        break;*/
                    
                        //J'envoi des commentaires
                        case 'sendCommentsFromId':
                            $commentsController = new CommentsController();
                            $commentsController->createNewComment();
                        break;
                        
                        //Je récupére le dernier article pour l'afficher sur le blog    
                        /*case 'getLastArticle':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getUniqueArticle();
                        break;*/
                    
                        //Je vais vers la vue ou s'affiche mes articles de mon blog
                        /*case 'myArticlesViewPage':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getTheArticleBlogPage();
                        break;*/
                        
                        //Je vais vers la vue contact ou s'affiche le formulaire de contact
                        /*case 'myContactViewPage':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getTheContactBlogPage();
                        break;*/
                        //Je récupére le dernier article pour l'afficher sur le blog
                        /*case 'goToLogOut';
                            $logoutController = new doLogout();
                            $logoutController->logout();*/
                        /*case 'untestdelupload':
                            $uploadController = new upload();
                            $uploadController->upload(); */
                        /*case 'actionGoToTheForm':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->getTheFormConnexion();*/
                            
                        /*case 'checkThePassAndUsername':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->checkThePassAndUsername();*/
                        
                        /*case 'mainBackendPage':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->getMainPage();*/
                            

                            
                        /*case 'datatablesArticles':
                            $postsController = new PostsControllers();
                            $postsController->getArticles();*/
                        
                        /*case 'removeArticles':
                            $postsController = new PostsControllers();
                            $postsController->deleteArticles();*/
                            
                        /*case 'writeAnArticle':
                            $postsController = new PostsControllers();
                            $postsController->writeAnArticle();*/
                        
                            /*case 'mainBackendPage':
                            $postsController = new PostsControllers();
                            $postsController->countArticles();
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->getTheMainBackendPage();*/
                            
                        //case 'countArticles':*/
                        
                    }