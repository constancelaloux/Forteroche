<?php

//namespace Forteroche\blogenalaska\controllers\backendcontrollers;

require_once('models/backendmodels/PostsManager.php');

    function postscontrol()
    {
    $postsManager = new \Forteroche\blogenalaska\models\backendmodels\PostsManager(); //Création d'un objet
    //On affiche les articles sur le backoffice
    $posts= $postsManager->sendPostsBlog();
    require('/index.php');
    }

/*class postscontrollers {
    
    public function postscontrol()
    {
    //On affiche les articles sur le backoffice
    $posts=sendPostsBlog();
    require('backendview.php');
    }
}*/
