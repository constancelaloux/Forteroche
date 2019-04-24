<?php

// Chargement des classes
//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//Autoloader::register();
//Backend
require_once'Backend/BackendControllers/FormAuthorAccessControler.php';
require_once'Backend/BackendControllers/PostsControllers.php';
//require_once'Backend/BackendControllers/doLogout.php';
require_once 'Backend/BackendControllers/upload.php';
require_once 'Backend/BackendControllers/commentsAdminControler.php';

//Frontend
require_once 'Frontend/FrontendControllers/BlogController.php';
require_once 'Frontend/FrontendControllers/CommentsController.php';
require_once 'Frontend/FrontendControllers/ClientController.php';
//Si j'ai une action ou sinon action par default

    (isset($_GET['action'])) ? $action = $_GET['action'] : $action = "goToFrontPageOfTheBlog";

                switch ($action)
                    {
//BACKEND
                //ADMIN
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
                                            
                        //Bouton de déconnexion
                        case 'disconnectTheAdmin':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->disconnect();
                        break;
                    
                //ARTICLES                
                        //Je compte les articles
                        case 'countArticles':  
                            $postsController = new PostsControllers();
                            $articlesCount = $postsController->countArticles();
                        break;
                    
                        //Je récupére les articles au sein du datatables
                        case 'getArticlesIntoDatatables':
                            $postsController = new PostsControllers();
                            $postsController->getArticles();
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
                        break;
                    
                        case 'articleUpdated':
                            $postsController = new PostsControllers();
                            $postsController->update(); 
                        break;
                        
                        // Je télécharge une image pour l'insérer dans mon article
                        case 'uploadImage':
                            $uploadController = new UploadControler();
                            $uploadController->upload();
                        break;
                    
                        case 'iGetImageIntoFormFromUploadPath':
                            $uploadController = new UploadControler();
                            $uploadController->upload2();
                        break;
                    
                //COMMENTAIRES                
                        //Je vais vers la vue ou il y a mon tableau dans lesquel s'affiche les commentaires
                    
                        case 'getCommentsViewDatatables':
                            $commentsAdminController = new CommentsAdminControler();
                            $commentsAdminController -> getCommentsView();   
                        break;  
                        
                        //Je vais récupérer les commentaires pour les afficher dans le tableau datatables
                        case 'getCommentsIntoDatatables':
                            $commentsAdminController = new CommentsAdminControler();
                            $commentsAdminController ->getCommentsIntoDatatables();
                        break;
                        
                        //Je vais supprimer les commentaires
                        case 'removeComments':
                            $commentsAdminController = new CommentsAdminControler();
                            $commentsAdminController -> removeComments(); 
                        break;

//FRONTEND              
                        //Je vais vers la page d'accueil de mon blog
                        case 'goToFrontPageOfTheBlog':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getTheMainFrontendBlogPage();
                        break;
                    
                //ARTICLES                  
                        //J'affiche les articles sur la premiére page du blog
                        case 'iGetArticlesToshowInTheBlogPage':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getArticles();
                        break;
                    
                        //J'ai récupéré l'id de l'article et je vais afficher l'article en entier et les commentaires de cet article
                        case 'getArticleFromId':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController->getTheArticleFromId();
                        break;
                    
                //COMMENTAIRES                
                        //J'envoi des commentaires
                        case 'sendCommentsFromId':
                            $commentsController = new CommentsController();
                            $commentsController->createNewComment();
                        break;
                    
                //CLIENT                    
                        //Je vais vers le formulaire de connexion client
                        case 'getTheFormClientsConnexion':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->getClientFormConnexion();
                        break;
                    
                        //Je vais vers le formulaire pour créer un client
                        case 'createNewClientForm':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->getFormToCreateNewClient();
                        break;
                    
                        //Je vais inserer en base les données du client
                        case 'createNewClientPasswordAndUsername':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->createNewClientInDatabase();
                        break;
                        
                        //Je vérifie les données mot de passe et identifiant du client pour accéder au blog
                        case 'checkThePassAndUsernameOfClient':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->checkClientUsernameAndPassword();
                        break;
                    
                        //bouton pour déconnecter le client
                        case 'disconnectTheClient':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->disconnectTheClient();
                        break;
                        
                        
                        //Je récupére les commentaires pour les afficher sur la page
                        /*case 'iGetCommentsToshowInTheBlogPage':
                            $commentsController = new CommentsController();
                            $commentsController->getListOfComments(); 
                        break;*/
                    
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