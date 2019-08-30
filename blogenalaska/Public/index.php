<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
/**
 * Autoload
 */
require(__DIR__ . '/../BlogenalaskaFram/vendor/autoload.php');
/**
 * Router
 */
//print_r($_SERVER['REQUEST_URI']);
//$uri = $_SERVER['REQUEST_URI'];
//echo $_SERVER['SERVER_NAME'];
$router = new AltoRouter();
$router->setBasePath('/blogenalaska/Public');

//On évite de répéter (__DIR__).'/views dans le require
//define('VIEW_PATH', dirname(__DIR__) .'/views');

//$test = dirname(__DIR__).'/views/post/index.php';
require '../config/Routes.php';
//$router->map($method, $route, $router);

//Est ce que l'url qui est tapé correspond à une de ces routes
$match = $router->match();

if (is_array($match)) 
    {
        if(is_callable($match['target']))
            {
                call_user_func_array($match['target'], $match['params']);
            //$match['target']();
            }
        else 
            {
                $params =$match['params'];
                ob_start();
                require __DIR__ ."/../views/{$match['target']}.php";
                $content = ob_get_clean();
            }
        require  __DIR__ .'/../Template/Layout.php';
    }
else {
    echo"HTTP/1.0 404 Not Found";
}
/*if($uri === '/nous-contacter')
    {
        print_r($_SERVER['REQUEST_URI']);
       require __DIR__ .'/../../views/index.php'; 
    }
else if ($uri === '/')
    {
        require __DIR__ .'/error/Page404.php';
    }
else
    {
            echo 'rien ne s est fait';
    };*/
/*$page = $_GET['page'] ?? '404';
//print_r($_GET['page']);
if($page === 'blog')
    {
        //exit("je sors");
        require __DIR__ .'/blog/index.php';
        //print_r($__DIR__ .'/blog/index.php');
    }
else if ($page === '404')
    {
        require __DIR__ .'/error/Page404.php';
    }
?><h1>Bienvenue sur mon site</h1>*/



//var_dump($_SERVER)

/*
print_r($router);
  
//Je vais voir si la route correspond à l'url qui est demandée
$match = $router->match();
print_r($router->match());

print_r($match['target']());
exit("je sors");
$match['target']();
print_r($match['target']());*/
//exit("je sors");
//use \blogenalaska\Test\Test2;
//use blogenalaska\Lib\BlogenalaskaFram\Application;
//use blogenalaska\Frontend\Modules\News\Controllers\NewsController;
//require"/Applications/MAMP/htdocs/Forteroche/blogenalaska/Test/Test2.php";
//phpinfo();
//echo 'Current PHP version: ' . phpversion();
//echo Forteroche\blogenalaska\Test\Test2::input();
//echo Test2::input();
/*$app = new Application();
$app->run();*/
//$app = new NewsController();
//$test =$app->executeIndex();
// Chargement des classes
/*require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();*/

//Si j'ai une action ou sinon action par default*/
/*    (isset($_GET['action'])) ? $action = $_GET['action'] : $action = "goToFrontPageOfTheBlog";

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
                    }*/