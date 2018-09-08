<?php

// Chargement des classes
require_once('models/backendmodels/AdminManager.php');

// Fonction qui permet d'ajouter un Administrateur ou Rédacteur du blog
function addAdmin()
{
    $adminManager = new \Forteroche\blogenalaska\models\backendmodels\AdminManager(); //Création d'un objet
    $sendAdminDatas = $adminManager->sendDatasBlogAdmin();
    if($sendAdminDatas === false) {
        throw new Exception('Impossible d\'ajouter les données administrateurs !');
    }
}




//on vérifie que les variables sont bien instanciés pour le formulaire d'entrée du back office
function transferdatatocontroler($usernamevar,$passwordvar)
{
    
    $adminManager = new \Forteroche\blogenalaska\models\backendmodels\AdminManager(); //Création d'un objet
    
    $donnees = $adminManager->getDataLog($usernamevar); // Appel d'une fonction de cet objet 

    //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
    $checkDonnees = password_verify($passwordvar, $donnees['password']);
    
    if ($checkDonnees)
    {   // Start the session
        session_start();
        $_SESSION['userName'] = $usernamevar;
        $_SESSION['firstName'] = $usernamevar;
        $_SESSION['surName'] = $usernamevar;
        redirectionVueAdmin();
    }
 else 
    {
        echo "Vos identifiants sont incorrects";
        
    }
}


