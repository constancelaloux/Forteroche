<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendControllers;

require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();
//require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/FrontendModels/Client.php';

require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/PdoConnection.php';

//require_once'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/FrontendModels/ClientManager.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ClientController
    {

//OBTENIR LE FORMULAIRE DE CONNEXION
       //Je vais vers le formulaire de connexion du client
        function getClientFormConnexion()
            {
                if (file_exists("Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php"))
                    {
                        require_once 'Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php';
                    }
                else
                    {
                        header('Location: /blogenalaska/Error/Page404.php');
                    }
                //require_once 'Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php';
            }
//FIN OBTENIR LE FORMULAIRE DE CONNEXION

            
            
//OBTENIR le FORMULAIRE DE CREATION D'UN CLIENT
        //Je vais vers le formulaire de création d'un nouveau client
        function getFormToCreateNewClient()
            {
                //require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                if (file_exists("Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php"))
                    {     
                        require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                    }
                else
                    {
                        header('Location: /blogenalaska/Error/Page404.php');
                    }
            }
//FIN OBTENIR LE FORMULAIRE DE CREATION D'UN CLIENT

            
            
//JE CREE UN NOUVEAU CLIENT EN BDD
        //Je créé un nouveau client et envoi en bdd ses informations
        function createNewClientInDatabase()
            {
                /*try
                    {*/
                        //Connexion à la base de données et création des identifiants du client
                        if (isset($_POST['login']) AND isset($_POST['pass']) AND isset($_POST['firstname']) AND isset($_POST['surname'])AND isset($_POST['image']))
                            {
                                if (!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['firstname']) && !empty($_POST['surname']) && !empty($_POST['image']))
                                    {
                                        // check if the username and the password has been set
                                        $firstnameVar = $_POST['firstname'];

                                        $surnameVar = $_POST['surname'];

                                        $usernameVar = $_POST['login'];

                                        $imageVar = $_POST['image'];

                                        //Je vérifie si mon identifiant n'est pas trop court
                                        if (strlen($usernameVar) > 20)
                                            {
                                                //throw new Exception('identifiant trop court !');
                                                $session = new SessionClass();
                                                $session->setFlash('identifiant trop court !','error');
                                                if (file_exists("Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php"))
                                                    {
                                                        require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                                                    }
                                                else
                                                    {
                                                        header('Location: /blogenalaska/Error/Page404.php');
                                                    }
                                            }
                                        //https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2917331-controlez-les-mots-de-passe
                                        //Je vérifie si mon mot de passe n'est pas trop court et conforme
                                        if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{6,8}$#', $_POST['pass'])) 
                                            {             
                                                $passwordVar = password_hash($_POST['pass'], PASSWORD_DEFAULT);

                                                $newClient = new Client
                                                    ([
                                                        'firstname' => $firstnameVar,
                                                        'surname' => $surnameVar,
                                                        'password' => $passwordVar,
                                                        'username' => $usernameVar,
                                                        'imageComment' => $imageVar
                                                    ]);

                                                    $db = \Forteroche\blogenalaska\PdoConnection::connect();

                                                    $manager = new ClientManager($db);

                                                    //Je vérifie si l'identifiant existe déja pour aller ensuite le comparer

                                                    if($manager->exists($newClient->username()))
                                                        {
                                                            //unset() détruit la ou les variables dont le nom a été passé en argument var.
                                                            unset($newClient);
                                                            $session = new SessionClass();
                                                            $session->setFlash('Votre identifiant existe déja','error');
                                                            if (file_exists("Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php"))
                                                               {
                                                                   require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                                                               }
                                                           else
                                                               {
                                                                   header('Location: /blogenalaska/Error/Page404.php');
                                                               }
                                                            //throw new Exception('Votre identifiant existe déja');
                                                            
                                                        }
                                                    else
                                                        {
                                                            $manager->add($newClient);
                                                            header('Location: /blogenalaska/index.php?action=getTheFormClientsConnexion');
                                                        }
                                                        //$sendToTheManager = $manager->add($newClient);
                                            }
                                        else 
                                            {
                                                $session = new SessionClass();
                                                $session->setFlash('Mot de passe pas conforme! Votre mot de passe doit '
                                                        . 'comporter au moins un caractére spécial, un chiffre, '
                                                        . 'une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum','error');
                                                if (file_exists("Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php"))
                                                    {
                                                        require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                                                    }
                                                else
                                                    {
                                                        header('Location: /blogenalaska/Error/Page404.php');
                                                    }
                                                //require_once'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                                                //throw new Exception('Mot de passe pas conforme! Votre mot de passe doit comporter au moins un caractére spécial, un chiffre, une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum');
                                            }
                                    }
                                else
                                    {
                                        //throw new Exception('Vous n\'avez pas rempli le formulaire!');
                                        $session = new SessionClass();
                                        $session->setFlash('Vous n\'avez pas rempli le formulaire!','error');
                                        if (file_exists("Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php"))
                                            {
                                                require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                                            }
                                        else
                                            {
                                                header('Location: /blogenalaska/Error/Page404.php');
                                            }
                                        //require_once'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                                    }
                            }
                        else 
                            {
                                //throw new Exception('Le ou les champs ne sont pas remplis !');
                                $session = new SessionClass();
                                $session->setFlash('Le ou les champs ne sont pas remplis !','error');
                                if (file_exists("Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php"))
                                    {
                                        require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                                    }
                                else
                                    {
                                        header('Location: /blogenalaska/Error/Page404.php');
                                    }
                                //require_once'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                            }
                    /*}*/
                /*catch(Exception $e) 
                    {
                        //S'il y a eu une erreur, alors...
                        echo 'Erreur : ' . $e->getMessage();
                        require_once'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                    }  */    
            }
//FIN JE CREE UN NOUVEAU CLIENT EN BDD

            
            
// JE VERIFIE LE MOT DE PASSE ET LE CLIENT
        //Vérifier l'identifiant et le mot de passe du client avant de le faire accéder à son compte
        function checkClientUsernameAndPassword()
            {
                // On vérifie les variables du formulaire si elles sont présentes et remplies
                try
                    {
                        // On vérifie les variables du formulaire si elles sont présentes et remplies
                        if (isset($_POST['username']) AND isset($_POST['password']))
                            {
                                if (!empty($_POST['username']) && !empty($_POST['password']))
                                    {
                                        // check if the username and the password has been set
                                        $clientUsernameVar = $_POST['username'];
                                        $clientPasswordVar = $_POST['password'];

                                        $client = new Client(
                                            [
                                                'username' => $clientUsernameVar,
                                                'password' => $clientPasswordVar

                                            ]); //Création d'un objet

                                        $db = \Forteroche\blogenalaska\PdoConnection::connect();

                                        $manager = new ClientManager($db);

                                        if($manager->exists($client->username()))
                                            {
                                                // Appel d'une fonction de cet objet
                                                $client = $manager->get($client->username());
                                                $idOfClientVar = $client->id();
                                                $imageOfClientVar = $client->imageComment();
                                                
                                                $passwordFromDb = $client->password();
                                                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                                                $clientPassword = password_verify($clientPasswordVar, $passwordFromDb);                  

                                                if ($clientPassword)
                                                    {
                                                        // Start the session
                                                        session_start();
                                                        $_SESSION['clientUsername'] = $clientUsernameVar;
                                                        $_SESSION['clientPassword'] = $clientPasswordVar;
                                                        $_SESSION['ClientId'] = $idOfClientVar;
                                                        $_SESSION['imageComment'] = $imageOfClientVar;

                                                        header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
                                                    }
                                                else 
                                                    {
                                                        throw new Exception('Votre mot de passe est incorrect!');
                                                    }
                                            }
                                        else 
                                            {
                                                throw new Exception('Votre nom d\'utilisateur est incorrect!');
                                            }
                                    }
                                else
                                    {
                                        throw new Exception('Tous les champs ne sont pas remplis !');
                                        //$session = new SessionClass();
                                        //$session->setFlash('Tous les champs ne sont pas remplis!','danger');
                                        //require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/test.php';
                                        //return $this->response->redirect('blogenalaska/test.php');
                                        //require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/test.php';
                                        //$setmessage = $session->flash();
                                        //$session->redirect();
                                        //header("Location:/blogenalaska/test.php");

                                        //header('location: /blogenalaska/test.php');
                                        //$session->flash();
                                        //print_r($session::setFlash('Tous les champs ne sont pas remplis!','error'));
                                        //print_r($_SESSION);
                                        //die("ouhhh je meurs et j en est marre");
                                        //require_once 'Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php';
                                
                                        //header('Location: /blogenalaska/Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php');
                                        //echo $session->flash();
                                        //die('je sors');   
                                        //print_r($_SESSION['flash']['message']);
                                                //print_r($session);
                                        //$msg->error();
                                        //$msg->sticky('This is "success" sticky message', 'http://redirect-url.com', $msg::SUCCESS);
                                        //$this->app->SessionClass()->setFlash();
                                        //header('Location: /blogenalaska/index.php?action=getTheFormClientsConnexion');
                                    }
                            }
                        else 
                            {
                                throw new Exception('Le ou les champs ne sont pas remplis !');
                            }
                    } 
                catch(Forteroche\blogenalaska\ExtendExceptions $e)
                    {
                        // S'il y a eu une erreur, alors...
                        $error = $e->getMessage();
                        require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/test.php';
                    }
                catch(Exception $e) 
                    {
                        // S'il y a eu une erreur, alors...
                        $error = $e->getMessage();
                        require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php';
                        //echo 'Erreur : ' .$e->getMessage();
                        //header('Location: /blogenalaska/index.php?action=getTheFormClientsConnexion');
                    }           
            }
//FIN JE VERIFIE LE MOT DE PASSE ET LE CLIENT 

            
            
//DECONNECTION D UN CLIENT
        //Déconnecter le client
        function disconnectTheClient()
            {
                session_start();
                // Suppression des variables de session et de la session
                // Réinitialisation du tableau de session
                // On le vide intégralement
                $_SESSION = array();
                // On détruit les variables de notre session
                session_unset ();
                session_destroy();
                
                header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
            }
// FIN DECONNEXION D UN CLIENT

            
            
//SUPPRIMER UN CLIENT
        //Supprimer le client
        function removeClient()
            {
                if(isset($_POST['data']))
                    {
                        //print_r($_POST['validateRemoveClient']);
                        $clientId = $_POST['data'];
                    }
                    
                $client = new Client(
                    [
                        'id' => $clientId,

                    ]); //Création d'un objet

                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $manager = new ClientManager($db);
                
                $removeClient = $manager->delete($client); 
            }
//FIN SUPPRIMER UN CLIENT
            
            
            
//METTRE A JOUR UN CLIENT
        function updateClientForm()
            {
            
                if(isset($_GET['id']))
                    {
                        $clientId = $_GET['id'];
                    }
                
                //header("Location: /blogenalaska/index.php?action=getUpdateClientForm&id='.$clientId'");
                require_once 'Frontend/FrontendViews/ClientFormAccess/ReinitiateClient.php';
            }
            
        //Réinitialiser le compte client
        function updateClient()
            {
                if(isset($_POST['id']) AND isset($_POST['password']))
                    {
                        if (!empty($_POST['id']) && !empty($_POST['password']))
                            {
                                $clientId = $_POST['id'];
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            }
                    }
                    
                $client = new Client(
                    [
                        'id' => $clientId,
                        'password' => $password

                    ]); //Création d'un objet

                $db = \Forteroche\blogenalaska\PdoConnection::connect();

                $manager = new ClientManager($db);
                
                $updateClient = $manager->update($client);
                
                header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
            }
//FIN METTRE A JOUR UN CLIENT
    }
 