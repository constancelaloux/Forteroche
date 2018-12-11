<?php
//index.php : ce sera le nom de notre routeur.
// Le routeur étant le premier fichier qu'on appelle en général sur un site, c'est normal 
// de le faire dans index.php. Il va se charger d'appeler le bon contrôleur.
// On appel le controleur
require'Controllers/BackendControllers/FormAuthorAccessControler.php';
require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Controllers/BackendControllers/PostsControllers.php';


//FORMULAIRE

//On vérifie si le mdp et l'identifiant du formulaire de connexion ont bien été envoyés
//On vérifie si il y a une action qui existe dans la vue
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'transferDataFormToControler')
            {
                // On vérifie les variables du formulaire si elles sont présentes et remplies
                if (isset($_POST['username']) AND isset($_POST['mot_de_passe']))
                    {
                        if (!empty($_POST['username']) && !empty($_POST['mot_de_passe']))
                            {
                                // check if the username and the password has been set
                                $usernameVar = ($_POST['username']);
                                $passwordVar = ($_POST['mot_de_passe']);

                                transferDatatoModel($usernameVar,$passwordVar);
                            }
                        else 
                            {
                                echo 'Tous les champs ne sont pas remplis';
                                sendDataToDatabase();
                            }
                    }   
            }
    }
else
    {
        // Si on a pas remplis le formulaire, on reste surle formlaire
       require'Views/Backend/AuthorFormAccess/FormAuthorAccessView.php';
    }


// Redirection vers la vue Administrateur
function redirectionGetArticles()
    {   
        //print_r("j'y suis");
        //exit();
        // On récupère nos variables de session
        if (isset($_SESSION['username']))
            {
                //getArticles();
                header('Location: http://localhost:8888/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php');
                
            }
    }



//ARTICLES

//Envoi des articles en base de données
    //On vérifie si il y a une action qui existe dans la vue
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'transferArticlesToController')
            {
                if (isset($_POST['content']) AND isset($_POST['title']))
                    {
                        if (!empty($_POST['content']) && !empty($_POST['title']))
                            {
                                $myText = ($_POST['content']);
                                $myTitle = ($_POST['title']);
                                transferArticlesToModel($myText, $myTitle);
                                // exit();
                            }
                        else 
                            {
                                // On fait un écho si les variables sont vides
                                echo('emptyvariables'); 
                            } 
                    }
            }

    }









