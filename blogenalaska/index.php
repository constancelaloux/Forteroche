<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Chargement des classes
//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
//Autoloader::register();
require_once'Controllers/BackendControllers/FormAuthorAccessControler.php';
require_once'Controllers/BackendControllers/PostsControllers.php';

//Si j'ai une action ou sinon action par default

    (isset($_GET['action'])) ? $action = $_GET['action'] : $action = "actionGoToTheForm";

    
                switch ($action)
                    {
                        case 'actionGoToTheForm':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->getTheFormConnexion();    
                        
                        case 'checkThePassAndUsername':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->checkThePassAndUsername();
                        
                        case 'mainBackendPage':
                            $sessionController = new FormAuthorAccessControler();
                            $sessionController->getTheMainBackendPage();
                            
                        //case 'countArticles':
                            $postsController = new PostsControllers();
                            $postsController->countArticles();
                            
                        case 'datatablesArticles':
                            $postsController = new PostsControllers();
                            $postsController->getArticles();
                        
                    }