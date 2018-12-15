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
    //exit("je sors");
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
                                //print_r("routeur");
                                transferDatatoModel($usernameVar,$passwordVar);

                            }
                        else 
                            {
                                echo 'Tous les champs ne sont pas remplis';
                                require'Views/Backend/AuthorFormAccess/FormAuthorAccessView.php';
                                sendDataToDatabase();
                            }
                    }   
            }
    }
else
    {
        //exit("je suis sorti");
        // On reste surle formlaire si il n'y a pas d'action
       require'Views/Backend/AuthorFormAccess/FormAuthorAccessView.php';
    }


// Redirection vers la vue Administrateur
function redirectionGetArticles()
    {       //print_r("je passe par la");
            //exit();
        //print_r("la redirection peut commencer");
        //exit("on y est");
        // On récupère nos variables de session
        //if (isset($_SESSION['username']))
            //{
                //print_r($_SESSION['username']);
                //exit("je sors");
                //getArticles();
                header('Location: http://localhost:8888/blogenalaska/Views/Backend/BackendViewFolders/BackendView.php');
                
            //}
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
                                //echo('Les champs ne sont pas remplis');
                                require'Views/Backend/BackendViewFolders/WriteArticlesView.php';
                            } 
                    }
            }

    }

//Action de la requéte ajax du Datatables
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'datatablesArticles')
            {
                //print_r("je passe dans l'index");
                //exit("test");
                getArticles();
                //print_r($POST[$json_data]);
            }
    }

//Action suppression données 
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'removeArticles?id=id')
            {
                //print_r("je passe dans l'index");
                if (isset($_GET['id']))
                    {
                        //print_r("j'ai un id");
                        if (!empty($_GET['id']))
                            {
                                // check if the id has been set
                                $myIdArticle = ($_GET['id']);
                                //print_r("je vais vers le controlleur");
                                deleteArticles($myIdArticle);

                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                require'Views/Backend/BackendViewFolders/BackendView.php';
                            }
                    } 
            }
    }

//Action modifier des données
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'UpdateArticles')
            {
                //print_r("je passe dans l'index");
                if (isset($_POST['id']))
                    {
                        if (!empty($_POST['id']))
                            {
                                // check if the id has been set
                                $myIdArticle = ($_POST['id']);
                                //print_r("routeur");
                                updateArticles($myIdArticle);
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                require'Views/Backend/BackendViewFolders/BackendView.php';
                            }
                    } 
            }
    }

