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

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/Author.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Controllers/PdoConnection.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/AuthorManager.php';
    
class FormAuthorAccessControler
    {
        //Je récupére le formulaire de connexion par default
        function getTheFormConnexion()
            {
                //header('Location:Views/Backend/AuthorFormAccess/FormAuthorAccessView.php');
                require'Views/Backend/AuthorFormAccess/FormAuthorAccessView.php';
            }
            
        //Fonction qui permet d'nvoyer les identifiants de l'utilisateur du backend en base
        /*function sendDataToDatabase()
            {
                //Connexion à la base de données et création des identifiants de Jean Forteroche
                $newAuthor = new Author
                    ([
                        'password' => password_hash('pass', PASSWORD_DEFAULT),
                        'username' =>'Jean_38',
                        'surname' => 'Forteroche',
                        'firstname' => 'Jean'
                    ]);

                    $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();
                    $sendToTheManager = new AuthorManager($db);
                    //$sendToTheManager->connect();
                    $sendToTheManager->add($newAuthor);
            }*/


        //Fonction qui permet de vérifier les identifiants de l'utilisateur
        //on vérifie que les variables sont bien instanciés pour le formulaire d'entrée du back office
        //function transferDatatoModel($usernameVar,$passwordVar)
        function checkThePassAndUsername()
            {
                // On vérifie les variables du formulaire si elles sont présentes et remplies
                if (isset($_POST['username']) AND isset($_POST['mot_de_passe']))
                    {
                        if (!empty($_POST['username']) && !empty($_POST['mot_de_passe']))
                            {
                                // check if the username and the password has been set
                                $usernameVar = ($_POST['username']);
                                $passwordVar = ($_POST['mot_de_passe']);

                                    //transferDatatoModel($usernameVar,$passwordVar);
                                    //Je compte mes articles
                                        //$Articles = countArticles();
                                $author = new Author(
                                    [
                                        'password' => $passwordVar,
                                        'username' => $usernameVar
                                    ]); //Création d'un objet

                                $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();

                                $manager = new AuthorManager($db);
                                $passwordFromManager = $manager->verify($author); // Appel d'une fonction de cet objet

                                $passwordFromDb = $passwordFromManager->password();

                                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                                $AuthorLogin = password_verify($passwordVar, $passwordFromDb);

                                if ($AuthorLogin)
                                    { 
                                        // Start the session
                                        session_start();
                                        $_SESSION['username'] = $usernameVar;
                                        header('Location: index.php?action="mainBackendPage"');
                                        //echo $_SESSION['username'];
                                        // $_SESSION['firstName'] = $usernameVar;
                                        // $_SESSION['surName'] = $usernameVar;
                                        //redirectionGetArticles();      
                                    }
                                else 
                                    {
                                        echo "Vos identifiants sont incorrects";
                                        //header('Location: index.php?action="actionGoToTheForm"');
                                        require'Views/Backend/AuthorFormAccess/FormAuthorAccessView.php';
                                         //header('Location:Views/Backend/AuthorFormAccess/FormAuthorAccessView.php');
                                    }
                                
                                /*if (isset($_SESSION['username']))
                                    {
                                        header('Location: index.php?action="mainBackendPage"');
                                        //require 'index.php?action="mainBackendPage';
                                    }
                                else
                                    {
                                        //header('Location: index.php?action="actionGoToTheForm"');
                                    }*/
                            }
                    }
            }
            
        //Function qui amméne vers la premiére page du backend
        function getTheMainBackendPage()
            {
                header('Location: Views/Backend/BackendViewFolders/BackendView.php');
                //require 'Views/Backend/BackendViewFolders/BackendView.php';
            }
    }
