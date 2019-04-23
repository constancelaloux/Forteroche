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
 
                                $author = new Author(
                                    [
                                        'username' => $usernameVar,
                                        'password' => $passwordVar
                                        
                                    ]); //Création d'un objet
                                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                                $manager = new AuthorManager($db);
                                $passwordFromManager = $manager->verify($author); // Appel d'une fonction de cet objet

                                $passwordFromDb = $passwordFromManager->password();

                                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                                $AuthorPassword = password_verify($passwordVar, $passwordFromDb);


                                if ($AuthorPassword)
                                    { 
                                        // Start the session
                                        session_start();
                                        $_SESSION['username'] = $usernameVar;
                                        $_SESSION['password'] = $passwordVar;
     
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
            
    }
