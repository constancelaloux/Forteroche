<?php

// On appel le controleur
require('controllers/backendcontrollers/formAccessControler.php');

// addAdmin(); // Appel test de la fonction pour créer un nouvel admin

//On vérifie si il y a une action qui existe dans la vue
if (isset($_GET['action']))
{
    //Si il y a une action, on appelle la fonction du controller
    if ($_GET['action'] == 'transferdatatocontroler')
    {
       // On vérifie les variables du formulaire si elles sont présentes et remplies
       if (isset($_POST['username']) AND isset($_POST['mot_de_passe']))
       {
           if (!empty($_POST['username']) && !empty($_POST['mot_de_passe']))
           {
               // check if the username and the password has been set
               $usernamevar = ($_POST['username']);
               $passwordvar = ($_POST['mot_de_passe']);

               transferdatatocontroler($usernamevar,$passwordvar);

           }
           else 
           {
               // On fait un écho si elles sont vides
               echo('emptyvariables'); 
           }
       }   
    }
}
else
{
    // On appel le formulaire de login pour l'afficher
   require('views/backend/formaccess/formaccessview.php');   
}
/* else
{
    echo 'Erreur: tous les champs ne sont pas remplis';
}*/
//postscontrol();
// Redirection vers la vue Administrateur
function redirectionVueAdmin()
{  
    header('Location:views/backend/mainbackendview/backendview.php');
    exit();
}



