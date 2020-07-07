<?php

/* 
 * List of frontend routes
 */

//Route qui récupére les aricles sur la page d'accueil du blog
$router->get('/', "Frontend#renderHomepage");

//Route qui renvoi les articles de la pagination
$router->get('/articles:page', "Frontend#renderPaginatedposts");

//Route qui va vers un article du frontend
$router->get('/article:id:page', "Frontend#renderPost");

//Route qui va vers un article du frontend et vers le commentaire qui peut etre modifié
$router->get('/article:id:idcomment', "Frontend#renderPost");

//Route qui permet de créer un commentaire
$router->post('/article:id', "Frontend#createComment");

//Route qui permet de modifier un commentaire
$router->post('/updatecomment:id:idcomment', "Frontend#updateComment");

//Route qui permet de supprimer un commentaire
$router->post('/deletecomment:id:idcomment', "Frontend#deleteComment");

//Route qui va gérer les clicks pour les commentaires indésirables
$router->post('/unwantedcomments', "Frontend#unwantedComment");

/* 
 * List of admin routes
 */

//Route qui amméne vers la fn qui créé un formulaire de création d'auteur
$router->get('/createuser', "Author#createUser");
$router->post('/createuser', "Author#createUser");

//Route qui permet de déconnecter un utilisateur
$router->post('/logout', "Author#logOut");

//Route qui va vers la fonction qui créé un formulaire de connexion
$router->get('/connectform', "Author#logUser");
$router->post('/connectform', "Author#logUser");

//Routes qui suppriment et met à jour un utilisateur
$router->get('/updateuser:id', "Author#updateUser");
$router->post('/updateuser:id', "Author#updateUser");

//Route qui supprime un utilisateur
$router->get('/deleteuser:id', "Author#deleteUser");

/*$router->get('/createclient', "Author#createClient");
$router->post('/createclient', "Author#createClient");*/

//Route qui va vers le formulaire de connexion du client
//$router->get('/connectclientform', "Client#logClient");
//$router->post('/connectclientform', "Client#logClient");

/* 
 * List of backend routes
 */

//Route qui va vers le backend
$router->get('/backoffice', "Backend#renderHomepage");

//Route qui va récupére les articles du datatables
$router->post('/listofarticles', "Backend#getListOfArticles");

//Route qui créé un article
$router->get('/createpost', "Backend#createPost");
$router->post('/createpost', "Backend#createPost");

//Route qui permet d'uploader une image
$router->post('/uploadimage', "Backend#uploadImage");

//Route qui permet d'insérer le chemin du fichier
$router->get('/iGetImageIntoFormFromUploadPath&data', "Backend#getImagePath");

//Route qui permet de mettre à jour un article
$router->get('/updatepost:id', "Backend#updatePost");
$router->post('/updatepost:id', "Backend#updatePost");

//Route qui permet de supprimer un article
$router->post('/deletepost', "Backend#deletePost");

//Route qui redirige si le post a bien été supprimé
$router->get('/confirmdeletepost', "Backend#confirmDeletedPost");

//Route qui rend la page avec les commentaires
$router->get('/rendercommentspage', "Backend#renderCommentsPage");

//Route qui récupére les commentaires au sein du tableau datatables
$router->post('/listofcomments', "Backend#getListOfComments");

//Route qui supprime un commentaire au sein du datatables
$router->post('/deletecommentfrombackend', "Backend#deleteComments");

//Route qui redirige apres avoir supprimé un commentaire du datatables
$router->get('/confirmdeletecomment', "Backend#confirmDeletedComments");

/**
 * Search articles
 */
$router->post('/searchPosts', "Search#search");

/**
 * Page 404
 */
$router->get('/page404', "Render#renderPage404");