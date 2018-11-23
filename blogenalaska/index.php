<?php
//index.php : ce sera le nom de notre routeur.
// Le routeur étant le premier fichier qu'on appelle en général sur un site, c'est normal 
// de le faire dans index.php. Il va se charger d'appeler le bon contrôleur.
//require_once("models/backendModels/AuthorManager.php");
// On appel le controleur
require('controllers/BackendControllers/FormAuthorAccessControler.php');
//test
//add(); // Appel test de la fonction pour créer un nouvel admin

//On vérifie si il y a une action qui existe dans la vue
if (isset($_GET['action']))
{
    //Si il y a une action, on appelle la fonction du controller
    if ($_GET['action'] === 'transferDatatoControler')
    {
       // On vérifie les variables du formulaire si elles sont présentes et remplies
       if (isset($_POST['username']) AND isset($_POST['mot_de_passe']))
       {
           if (!empty($_POST['username']) && !empty($_POST['mot_de_passe']))
           {
               // check if the username and the password has been set
               $usernameVar = ($_POST['username']);
               $passwordVar = ($_POST['mot_de_passe']);
               print_r($usernameVar);
                              print_r("je vais vers le controller");
               transferDatatoModel($usernameVar,$passwordVar);
               //echo 'je vais vers le controller';

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
else
{
    // Si on a pas remplis le formulaire, on reste surle formlaire
   require('views/backend/AuthorFormAccess/FormAuthorAccessView.php');
   //print_r("Tous les champs ne sont pas remplis");
}
/*
else
{
    echo 'Erreur: tous les champs ne sont pas remplis';
}
 */

//postscontrol();
// Redirection vers la vue Administrateur
function redirectionVueAdmin()
    {  
        header('Location:/views/backend/MainBackendView/backendView.php');
        //exit();
    }



