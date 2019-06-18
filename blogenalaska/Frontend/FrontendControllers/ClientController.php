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
       //Je vais vers le formulaire de connexion du client
        function getClientFormConnexion()
            {
                require_once 'Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php';
            }
        
        //Je vais vers le formulaire de création d'un nouveau client
        function getFormToCreateNewClient()
            {
                require_once 'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
            }
        
        //Je créé un nouveau client et envoi en bdd ses informations
        function createNewClientInDatabase()
            {
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
                                $sendToTheManager = $manager->add($newClient);

                                header('Location: /blogenalaska/index.php?action=getTheFormClientsConnexion');
                            }
                        else
                            {
                                echo "Vous n'avez pas rempli le formulaire";
                                require_once'Frontend/FrontendViews/ClientFormAccess/CreateNewClient.php';
                            }
                    }       
            }
        
        //Vérifier l'identifiant et le mot de passe du client avant de le faire accéder à son compte
        function checkClientUsernameAndPassword()
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
                                $passwordFromManager = $manager->verify($client); // Appel d'une fonction de cet objet

                                $passwordFromDb = $passwordFromManager->password();
                                $idOfClientVar = $passwordFromManager->id();
                                $imageOfClientVar = $passwordFromManager->imageComment();
                                $firstnameOfClientVar = $passwordFromManager->firstname();

                                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                                $AuthorPassword = password_verify($clientPasswordVar, $passwordFromDb);

                                if ($AuthorPassword)
                                    { 
                                        // Start the session
                                        session_start();
                                        $_SESSION['clientUsername'] = $firstnameOfClientVar;
                                        $_SESSION['clientPassword'] = $clientPasswordVar;
                                        $_SESSION['ClientId'] = $idOfClientVar;
                                        $_SESSION['imageComment'] = $imageOfClientVar;

                                header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
            
                                                                    }
                                else 
                                    {
                                        echo "Vos identifiants sont incorrects";
                                    
                                        header('Location: /blogenalaska/index.php?action=getTheFormClientsConnexion');
                                    }
                            }
                    }
            }
        
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
    }
 