<?php

//Contrôleur : cette partie gère la logique du code qui prend des décisions.
// C'est en quelque sorte l'intermédiaire entre le modèle et la vue : 
// le contrôleur va demander au modèle les données, les analyser, prendre des décisions et renvoyer le texte 
// à afficher à la vue. Le contrôleur contient exclusivement du PHP. C'est notamment lui qui détermine 
// si le visiteur a le droit de voir la page ou non (gestion des droits d'accès).

// Le controleur implémentera une seule méthode: executeIndex(). Cette méthode devra,
// si le formulaire a été envoyé, vérifier si le pseudo et le mdp entrés sont corrects.
// Si c'est le cas, l'utilisateur est authentifié, sinon un msg erreur s'affiche.
    // Chargement des classes
    //require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
    //Autoloader::register();

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/Author.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendModels/AuthorManager.php';
    
class FormAuthorAccessControler
    {
//CREATION D'UN ADMIN
       
        //Je récupére le formulaire pour envoyer des données administrateur en bdd
        function getFormToCreateNewAdmin()
            {
                require 'Backend/BackendViews/AuthorFormAccess/CreateNewAuthor.php';
            }
            
        //Fonction qui permet d'nvoyer les identifiants de l'utilisateur du backend en base
        function createNewAdmin()
            {
                //Connexion à la base de données et création des identifiants de Jean Forteroche
                    if (isset($_POST['login']) AND isset($_POST['pass']))
                        {
                            if (!empty($_POST['login']) && !empty($_POST['pass']))
                                {
                                    // check if the username and the password has been set
                                    $firstnameVar = ($_POST['firstname']);
                                    
                                    $surnameVar = ($_POST['surname']);
                                    
                                    $usernameVar = ($_POST['login']);
       
                                    $passwordVar = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                                    
                                    $newAuthor = new Author
                                        ([
                                            'firstname' => $firstnameVar,
                                            'surname' => $surnameVar,
                                            'password' => $passwordVar,
                                            'username' => $usernameVar
                                        ]);
                                    $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                                    $manager = new AuthorManager($db);
                                    $sendToTheManager = $manager->add($newAuthor);
                                    //echo '<p>Ligne à copier dans le .htpasswd :<br />' . $usernameVar . ':' . $passwordVar . '</p>';
                                }
                            else
                                {
                                    echo "Vous n'avez pas rempli le formulaire";
                                    require'Backend/ AuthorFormAccess/CreateNewAuthor.php';
                                }
                        }
            }

//CONNEXION AU BACKEND PAR UN UTILISATEUR

        //Je récupére le formulaire de connexion par default
        function getTheFormAdminConnexionBackend()
            {
                require'Backend/BackendViews/AuthorFormAccess/FormAuthorAccessView.php';
            }
            
        //Fonction qui permet de vérifier les identifiants de l'utilisateur
        //on vérifie que les variables sont bien instanciés pour le formulaire d'entrée du back office
        //function transferDatatoModel($usernameVar,$passwordVar)
        function checkThePassAndUsername()
            {
            //print_r("je vais recup mes variables de connexion et vérifier ma connexion");
                // On vérifie les variables du formulaire si elles sont présentes et remplies
                if (isset($_POST['username']) AND isset($_POST['password']))
                    {
                        if (!empty($_POST['username']) && !empty($_POST['password']))
                            {
                                // check if the username and the password has been set
                                $usernameVar = ($_POST['username']);
                                $passwordVar = ($_POST['password']);
 
                                //transferDatatoModel($usernameVar,$passwordVar);
                                //Je compte mes articles
                                //$Articles = countArticles();
                                $author = new Author(
                                    [
                                        'username' => $usernameVar,
                                        'password' => $passwordVar
                                        
                                    ]); //Création d'un objet
                                    //print_r($author);
                                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                                $manager = new AuthorManager($db);
                                $passwordFromManager = $manager->verify($author); // Appel d'une fonction de cet objet
                                //print_r("je reviens dans le controler");
                                //print_r($manager->verify($author));
                                $passwordFromDb = $passwordFromManager->password();
                                //print_r($passwordFromDb);
                                //$usernameFromDb = $passwordFromManager->username();
                                //print_r($usernameFromDb);

                                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                                $AuthorPassword = password_verify($passwordVar, $passwordFromDb);
                                //print_r($AuthorPassword);
                                //$AuthorLogin = password_verify($usernameVar, $usernameFromDb);
                                //print_r($AuthorLogin);

                                if ($AuthorPassword)
                                    { 
                                        // Start the session
                                        session_start();
                                        $_SESSION['username'] = $usernameVar;
                                        $_SESSION['password'] = $passwordVar;
                                        
                                        //session timeout
 
                                        //Expire the session if user is inactive for 30
                                        //minutes or more.
                                        //$expireAfter = 1;

                                        //Check to see if our "last action" session
                                        //variable has been set.
                                        /*if(isset($_SESSION['last_action']))
                                            {

                                                //Figure out how many seconds have passed
                                                //since the user was last active.
                                                $secondsInactive = time() - $_SESSION['last_action'];

                                                //Convert our minutes into seconds.
                                                $expireAfterSeconds = $expireAfter * 60;

                                                //Check to see if they have been inactive for too long.
                                                if($secondsInactive >= $expireAfterSeconds)
                                                    {
                                                        //User has been inactive for too long.
                                                        //Kill their session.
                                                        print_r("ma session est inactive");
                                                        session_unset();
                                                        session_destroy();
                                                    }
                                            }*/

                                        //Assign the current timestamp as the user's
                                        //latest activity
                                        //$_SESSION['last_action'] = time();
                                        //session_set_cookie_params(24*3600);
                                        /*if (isset($_SESSION))
                                            {*/
                                                /*$inactive = 10;
                                                //print_r($inactive);
                                                
                                                $_SESSION['timeout']=time();
                                                //print_r($_SESSION['timeout']);
                                                $session_life = time() - $_SESSION['timeout'];                                               
                                                //print_r($session_life);
                                                //print_r($session_life);
                                                    
                                                if($session_life > $inactive) 
                                                    {
                                                    print_r('la session est inactive');
                                                        session_destroy(); 
                                                        header("Location: /Backend/BackendViews/AuthorFormAccess/FormAuthorAccessView.php"); 
                                                    }*/
                                            //}

                                        //print_r(ini_set("session.gc_maxlifetime", 60));
                                       // header('Location: Backend/BackendViews/BackendViewFolders/BackendView.php');      
                                        header('Location: /blogenalaska/index.php?action=countArticles');
                                        
                                    }
                                else 
                                    {
                                        echo "Vos identifiants sont incorrects";
                                        require_once'Backend/BackendViews/AuthorFormAccess/FormAuthorAccessView.php';
                                    }

                            }
                            
                        else if (empty($_POST['username']) && empty($_POST['mot_de_passe']))
                            {
                                echo "Remplissez les champs suivants";
                                require_once'Backend/BackendViews/AuthorFormAccess/FormAuthorAccessView.php';
                            }
                    }

            }
//DECONNEXION DU BACKEND PAR L'UTILISATEUR            
        function disconnect()
            {
                session_start();
                // Suppression des variables de session et de la session
                // Réinitialisation du tableau de session
                // On le vide intégralement
                $_SESSION = array();
                // On détruit les variables de notre session
                session_unset ();
                session_destroy();
                
                header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
            }
            
        //Je suis rentré dans la session et je vais vers la page principale de mon backend        
        /*function getMainPage()
            {
                require 'Views/Backend/BackendViewFolders/BackendView.php';
                //header('Location: Views/Backend/BackendViewFolders/BackendView.php');
            }*/
            
    }
