<?php
// Chargement des classes
require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();

//Si j'ai une action ou sinon action par default*/
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
                   
                        //Je supprime un article
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
                            $postsController = new PostsControllers();     
                            $postsController->createNewArticle();
                        break;
                    
                        //Je sauvegarde un article en base de données mais celui ci n'est pas validé
                        case 'saveArticleBeforeToValidate':
                            $postsController = new PostsControllers();     
                            $postsController->saveNewArticle();
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
                    
                        //L'article est mis à jour en base de données
                        case 'articleUpdated':
                            $postsController = new PostsControllers();
                            $postsController->update(); 
                        break;
                    
                        //L'article est mis à jour en base de données mais il est juste sauvegardé
                        case 'updateArticleBeforeToValidate':
                            $postsController = new PostsControllers();
                            $postsController->saveArticleFromUpdate(); 
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
                    
                        //Compter le nombre de commentaires
                        case 'countCommentsForAdminTableView':
                            $commentsAdminController = new CommentsAdminControler();
                            $commentsAdminController ->countComments();
                        break;
                    
                        //Je vais supprimer les commentaires
                        case 'removeComments':
                            $commentsAdminController = new CommentsAdminControler();
                            $commentsAdminController -> removeComments(); 
                        break;
                    
                        //Valider les commentaires du datatables qui ont ete considérés comme signalés
                        case 'validateArticles':
                            $commentsAdminController = new CommentsAdminControler();
                            $commentsAdminController -> validateComment(); 
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
                    
                        //je récupére en base de données le nombre de signalements en fonction de l'id du commentaire
                        case 'unwantedComments':
                            $commentsController = new CommentsController();
                            $commentsController->unwantedComments();
                        break;
                    
                        //Je vais aller modifier le nombre de signalements en base de données et ajouter la mention unwanted
                        case 'addStatusAndNumberOfClicksToComment':
                            $commentsController = new CommentsController();
                            $commentsController->addStatusAndNumberOfClicksToComment();
                        break;
                    
                        //je récupére le commentaire en base de données pour aller le modifier
                        case 'getCommentFromIdBeforeToUpdate':
                            $commentsAdminController = new CommentsController();
                            $commentsAdminController -> getCommentFromIdBeforeToUpdate(); 
                        break;
                        
                        //Je modifie le commentaire
                        case 'updateComment':
                            $commentsAdminController = new CommentsController();
                            $commentsAdminController ->updateComment(); 
                        break;
                    
                        //Je supprime un commentaire
                        case 'removeComment':
                            $commentsAdminController = new CommentsController();
                            $commentsAdminController ->removeComment(); 
                        break;
                //RECHERCHER
                        case'search':
                            $blogFrontendController = new BlogController();
                            $blogFrontendController ->search();
                        break;
                //CLIENT                    
                        //Je vais vers le formulaire de connexion de l'utilisateur
                        case 'getTheFormClientsConnexion':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->getClientFormConnexion();
                        break;
                    
                        //Je vais vers le formulaire pour créer un utilisateur
                        case 'createNewClientForm':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->getFormToCreateNewClient();
                        break;
                    
                        //Je vais inserer en base les données de l'utilisateur
                        case 'createNewClientPasswordAndUsername':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->createNewClientInDatabase();
                        break;
                        
                        //Je vérifie les données mot de passe et identifiant de l'utilisateur pour accéder au blog
                        case 'checkThePassAndUsernameOfClient':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->checkClientUsernameAndPassword();
                            //require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/test.php';
                        break;
                    
                        //bouton pour déconnecter l'utilisateur
                        case 'disconnectTheClient':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->disconnectTheClient();
                        break;
                    
                        //Supprimer un client
                        case 'removeClient':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->removeClient();
                        break;
                    
                        //réinitialiser un client
                        case 'updateClientForm':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->updateClientForm();
                        break;
                    
                        case  'updateClient':
                            $clientFrontendController = new ClientController();
                            $clientFrontendController->updateClient();
                        break;
                //EMAIL
                        //L'utilisateur envoi un email à l'administrateur
                        case 'sendEmail':
                            $EmailFrontendController = new EmailController();
                            $EmailFrontendController->sendEmail();
                        break;
                    }