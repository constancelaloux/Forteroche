<?php
//namespace Forteroche\blogenalaska\Backend\BackendControllers;
//Contrôleur : cette partie gère la logique du code qui prend des décisions.
// C'est en quelque sorte l'intermédiaire entre le modèle et la vue : 
// le contrôleur va demander au modèle les données, les analyser, prendre des décisions et renvoyer le texte 
// à afficher à la vue. Le contrôleur contient exclusivement du PHP. C'est notamment lui qui détermine 
// si le visiteur a le droit de voir la page ou non (gestion des droits d'accès).

// Le controleur implémentera une seule méthode: executeIndex(). Cette méthode devra,
// si le formulaire a été envoyé, vérifier si le pseudo et le mdp entrés sont corrects.
// Si c'est le cas, l'utilisateur est authentifié, sinon un msg erreur s'affiche.
// Chargement des classes
/*require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();*/

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/models/PdoConnection.php';

class FormAuthorAccessControler
    {
//CREATION D'UN ADMIN
       
        //Je récupére le formulaire pour envoyer des données administrateur en bdd
        function getFormToCreateNewAdmin()
            {
                if (file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'))
                    {
                        require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php';
                    }
                else
                    {
                        header('Location: /blogenalaska/views/Page404.php');
                    }
            }
            
        //Fonction qui permet d'nvoyer les identifiants de l'utilisateur du backend en base
        function createNewAdmin()
            {
                /*try
                    {*/
                        //Connexion à la base de données et création des identifiants de Jean Forteroche
                        if (isset($_POST['login']) AND isset($_POST['pass']) AND isset($_POST['firstname']) AND isset($_POST['surname']))
                            {
                                if (!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['firstname']) && !empty($_POST['surname']))
                                    {
                                        // check if the username and the password has been set
                                        $firstnameVar = $_POST['firstname'];

                                        $surnameVar = $_POST['surname'];

                                        $usernameVar = $_POST['login'];
                                        
                                        //Je vérifie si mon identifiant n'est pas trop court
                                        if (strlen($usernameVar) > 20)
                                            {
                                                //throw new Exception('identifiant trop court !');
                                                $session = new SessionClass();
                                                $session->setFlash('identifiant trop court !','error');
                                                if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'))
                                                    {
                                                       require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'; 
                                                    }
                                                else
                                                    {
                                                        header('Location: /blogenalaska/views/Page404.php');
                                                    }
                                            }
                                            
                                        //https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2917331-controlez-les-mots-de-passe
                                        //Je vérifie si mon mot de passe n'est pas trop court et conforme
                                        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,8}$#', $_POST['pass'])) 
                                            {
                                                $passwordVar = password_hash($_POST['pass'], PASSWORD_DEFAULT);
                                                //On créé un nouveau personnage
                                                $newAuthor = new Author
                                                    ([
                                                        'firstname' => $firstnameVar,
                                                        'surname' => $surnameVar,
                                                        'password' => $passwordVar,
                                                        'username' => $usernameVar
                                                    ]);
                                                //On se connecte à la base de données
                                                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                                                //On fait appelle à la classe Authormanager ou l'on fait les requetes
                                                $manager = new AuthorManager($db);
                                                
                                                //Je vérifie si l'identifiant existe déja pour aller ensuite le comparer

                                                if($manager->exists($newAuthor->username()))
                                                    {
                                                        //unset() détruit la ou les variables dont le nom a été passé en argument var.
                                                        unset($newAuthor);
                                                        //throw new Exception('Votre identifiant existe déja');
                                                        $session = new SessionClass();
                                                        $session->setFlash('Votre identifiant existe déja','error');
                                                        if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'))
                                                            {
                                                               require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'; 
                                                            }
                                                        else
                                                            {
                                                                header('Location: /blogenalaska/views/Page404.php');
                                                            }
                                                    }
                                                else
                                                    {
                                                        $manager->add($newAuthor);
                                                        header('Location: /public/index.php?action=getTheFormAdminConnexionBackend');
                                                    }
                                            }	
                                        else 
                                            {
                                                $session = new SessionClass();
                                                $session->setFlash('Mot de passe pas conforme! Votre mot de passe '
                                                        . 'doit comporter au moins un caractére spécial, un chiffre, une majuscule et minuscule, '
                                                        . 'et doit etre entre 6 caractéres minimum et 8 maximum','error');
                                                if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'))
                                                    {
                                                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php';
                                                    }
                                                else
                                                    {
                                                        header('Location: /blogenalaska/views/Page404.php');
                                                    }
                                                //throw new Exception('Mot de passe pas conforme! Votre mot de passe doit comporter au moins un caractére spécial, un chiffre, une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum');
                                            }
                                    }
                                else
                                    {
                                        $session = new SessionClass();
                                        $session->setFlash('Vous n\'avez pas rempli le formulaire!','error');
                                        if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'))
                                            {
                                                require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php';
                                            }
                                        else
                                            {
                                                header('Location: /blogenalaska/views/Page404.php');
                                            }
                                        //throw new Exception('Vous n\'avez pas rempli le formulaire!');
                                    }
                            }
                        else 
                            {
                                $session = new SessionClass();
                                $session->setFlash('Le ou les champs ne sont pas remplis !','error');
                                if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'))
                                    {
                                       require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/CreateNewAuthor.php'; 
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                                //throw new Exception('Le ou les champs ne sont pas remplis !');
                            }
                /*    }
                catch(Exception $e) 
                    {
                         //S'il y a eu une erreur, alors...
                        echo 'Erreur : ' . $e->getMessage();
                        require_once'Backend/BackendViews/AuthorFormAccess/CreateNewAuthor.php';
                    }*/
            }

//CONNEXION AU BACKEND PAR UN ADMIN

        //Je récupére le formulaire de connexion par default
        function getTheFormAdminConnexionBackend()
            {
                if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'))
                    {
                        require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php';
                    }
                else
                    {
                        header('Location: /blogenalaska/views/Page404.php');
                    }
            }
            
        //Fonction qui permet de vérifier les identifiants de l'utilisateur
        //on vérifie que les variables sont bien instanciés pour le formulaire d'entrée du back office
        //function transferDatatoModel($usernameVar,$passwordVar)
        function checkThePassAndUsername()
            {
                // On vérifie les variables du formulaire si elles sont présentes et remplies
                /*try
                    {*/
                        if (isset($_POST['username']) AND isset($_POST['password']))
                            {
                                if (!empty($_POST['username']) && !empty($_POST['password']))
                                    {
                                        // check if the username and the password has been set
                                        $usernameVar = $_POST['username'];
                                        $passwordVar = $_POST['password'];

                                        $author = new Author(
                                            [
                                                'username' => $usernameVar,
                                                'password' => $passwordVar

                                            ]); //Création d'un objet
                                        //print_r($passwordVar);
                                        $db = \Forteroche\blogenalaska\PdoConnection::connect();

                                        $manager = new AuthorManager($db);
                                        
                                        if($manager->exists($author->username()))
                                            { 
                                                // Appel d'une fonction de cet objet
                                                $author = $manager->get($author->username());
                                                $passwordFromDb = $author->password();
                                                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                                                $AuthorPassword = password_verify($passwordVar, $passwordFromDb);
                                                
                                                if ($AuthorPassword)
                                                    {
                                                        // Start the session
                                                        session_start();
                                                        $_SESSION['username'] = $usernameVar;
                                                        $_SESSION['password'] = $passwordVar;

                                                        header('Location: /public/index.php?action=countArticles');
                                                    }
                                                else 
                                                    {
                                                        $session = new SessionClass();
                                                        $session->setFlash('Votre mot de passe est incorrect!','error');
                                                        if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'))
                                                            {
                                                               require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'; 
                                                            }
                                                        else
                                                            {
                                                                header('Location: /blogenalaska/views/Page404.php');
                                                            }
                                                        //throw new Exception('Votre mot de passe est incorrect!');
                                                    }
                                            }
                                        else 
                                            {
                                                $session = new SessionClass();
                                                $session->setFlash('Votre nom d\'utilisateur est incorrect!','error');
                                                if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'))
                                                    {
                                                       require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'; 
                                                    }
                                                else
                                                    {
                                                        header('Location: /blogenalaska/views/Page404.php');
                                                    }
                                                //throw new Exception('Votre nom d\'utilisateur est incorrect!');
                                            }

                                    }

                                else
                                    {
                                        $session = new SessionClass();
                                        $session->setFlash('Tous les champs ne sont pas remplis !','error');
                                        if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'))
                                            {
                                               require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'; 
                                            }
                                        else
                                            {
                                                header('Location: /blogenalaska/views/Page404.php');
                                            }
                                        //throw new Exception('Tous les champs ne sont pas remplis !');
                                    }
                            //die('je continue dans le script');
                            }
                        else 
                            {
                                die('je passe pas dans le isset');
                                $session = new SessionClass();
                                $session->setFlash('Le ou les champs ne sont pas remplis !','error');
                                if(file_exists('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'))
                                    {
                                       require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/FormAuthorAccessView.php'; 
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/views/Page404.php');
                                    }
                                //throw new Exception('Le ou les champs ne sont pas remplis !');
                            }
                /*    } 
                catch(Exception $e) 
                    {
                        // S'il y a eu une erreur, alors...
                        echo 'Erreur : ' . $e->getMessage();
                        require_once'Backend/BackendViews/AuthorFormAccess/FormAuthorAccessView.php';
                    }*/
            }
            
//DECONNEXION DU BACKEND PAR UN ADMIN            
        function disconnect()
            {
                /*try
                    {*/
                        session_start();

                        // Suppression des variables de session et de la session
                        // Réinitialisation du tableau de session
                        // On le vide intégralement
                        $_SESSION = array();
                        // On détruit les variables de notre session
                        session_unset ();
                        session_destroy();
                        
                        if(!session_id())
                            {
                                header('Location: /public/index.php?action=getTheFormAdminConnexionBackend');
                            }
                        else
                            {
                                $session = new SessionClass();
                                $session->setFlash('Vous n etes pas déconnecté !','error');
                                /*if(file_exists('Backend/BackendViews/AuthorFormAccess/FormAuthorAccessView.php'))
                                    {
                                       require_once'Backend/BackendViews/AuthorFormAccess/FormAuthorAccessView.php'; 
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/Error/Page404.php');
                                    }*/
                                //throw new Exception('Vous n etes pas déconnecté !');
                            }
                /*    } 
                catch(Exception $e) 
                    {
                        header('Location: /blogenalaska/index.php?action=countArticles&error='.$e->getMessage());
                    }*/
            }
            
    }
