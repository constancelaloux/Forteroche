<?php
//index.php : ce sera le nom de notre routeur.
// Le routeur étant le premier fichier qu'on appelle en général sur un site, c'est normal 
// de le faire dans index.php. Il va se charger d'appeler le bon contrôleur.
// On appel le controleur
require'Controllers/BackendControllers/FormAuthorAccessControler.php';
require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Controllers/BackendControllers/PostsControllers.php';

//$PostControllers = new PostControllers();
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
                                //Je compte mes articles
                                $Articles = countArticles();
                                //Je vais dans mon backend
                                require 'Views/Backend/BackendViewFolders/BackendView.php';
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
        // On reste surle formlaire si il n'y a pas d'action
       require'Views/Backend/AuthorFormAccess/FormAuthorAccessView.php';
    }

//MENU
//Accueil
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'mainBackendPage')
            {
                require 'Views/Backend/BackendViewFolders/BackendView.php';
            }
    }   

//Action du lien menu pour aller écrire un article
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'writeAnArticle')
            {
                require 'Views/Backend/BackendViewFolders/WriteArticlesView.php';
            }
    }
    
//Action pour aller sur le blog
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'goToTheBlog')
            {
                require 'Views/Frontend/Accueil.php';
            }
    }
    
//ARTICLES

//Action de la requéte ajax du Datatables
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'datatablesArticles')
            {
                getArticles();
            }
    }

//Action envoi des articles en base de données
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
                                require 'Views/Backend/BackendViewFolders/BackendView.php';
                            }
                        else 
                            {
                                // On fait un écho si les variables sont vides
                                echo('Les champs ne sont pas remplis');
                                require'Views/Backend/BackendViewFolders/WriteArticlesView.php';
                            } 
                    }
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
                        if (!empty($_GET['id']))
                            {
                                // check if the id has been set
                                $myIdArticle = ($_GET['id']);
                                deleteArticles($myIdArticle);
                                require'Views/Backend/BackendViewFolders/BackendView.php';
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

//Je récup l'action de mon datatables et je vais récup les données en fonction de l'id en base
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'updateArticles?id=id')
            {
                if (isset($_GET['id']))
                    {
                        if (!empty($_GET['id']))
                            {
                                // check if the id has been set
                                $myIdArticle = ($_GET['id']);

                                $articleSubject = getArticlesFromId($myIdArticle);
                               
                                //print_r($articleSubject);
                                //exit("je sors");
                                //('Location: index.php?action=post');
                                require'Views/Backend/BackendViewFolders/ModifyArticlesView.php';
                            }
                        else 
                            {
                                echo 'pas d article séléctionné';
                                require'Views/Backend/BackendViewFolders/BackendView.php';
                            }
                    } 
            }
    }


//J'ai une action dans mon formulaire quand je valide qui va aller modifier l'article en base en fonction de l'id
if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'articleUpdated')
            {
                //print_r("je passe dans l'index");
                if (isset($_POST['subject']) and ($_POST['content']) and ($_POST['id']))
                    {
                        if (!empty($_POST['subject']) and ($_POST['content']) and ($_POST['id']))
                            {
                                $myText = ($_POST['content']);
                                $myTitle = ($_POST['title']);
                                $myId =  ($_POST['id']);
                                update($myText, $myTitle, $myId);
                            }
                        else 
                            {
                                echo 'pas de données dans le formulaire';
                                //On reste sur le formulaire
                                //require'Views/Backend/BackendViewFolders/BackendView.php';
                            }
                    } 
            }
    }

//BLOG

//Action compter les news

/*if (isset($_GET['action']))
    {
        //Si il y a une action, on appelle la fonction du controller
        if ($_GET['action'] === 'CountArticles')
            {
                countArticles();
                //print_r();
                print_r($articlesCount);
            }
    }*/

