<?php

/* 
 *Liste de mes routes à écrire
 */

//Route vers fn qui permet de rediriger vers une vue
//$router->get('/', "Author#redirectView");

//Route vers fn qui permet de rendre une vue
//$router->get('/renderView', "Author#renderView");

//Route vers fn qui permet de laisser un msg flash et rendre une vue
//$router->get('/flashMessage', "Author#FlashMessageAndRenderView");

//Route qui amméne vers la fn qui créé un formulaire de création d'auteur
$router->get('/', "Author#createAuthor");
$router->post('/', "Author#createAuthor");

//Route qui amméne vers la fn qui valide et gére les données
//$router->post('/test', "Author#getValidateAndSendDatasFromForm");

//Route qui va vers la fonction qui créé un formulaire de connexion
$router->get('/connectForm', "Author#logAuthor");
$router->post('/connectForm', "Author#logAuthor");

//Route qui récupére les identifiants de connexion de l'auteur
//$router->post('/validateAuthorConnexion', "Author#validateConnexion");

//Route qui va vers le back office de l'administrateur
$router->post('/getListOfArticles', "BackOffice#getListOfArticles");

//Route qui va vers le blog
$router->get('/getBackoffice', "BackOffice#renderBackoffice");
//Route qui récupére les articles pour le datatables
$router->get('/Blog', "Blog#renderBlog");

//$router->get('/t', function(){ echo "Bienvenue !"; }); 
//$router->get('/', function(){ echo "Bienvenue !"; }); 
//$router->get('/', "Posts#getPage");

//$router->get('/test', function(){ echo "Bienvenue sur ma homepage !"; }); 
//$router->get('/test/:id-:slug', function($id, $slug)
/*        use($router)
        { 
            //echo "Voila article $slug:$id";   
            echo $router->url('Posts.show', ['id'=>1, 'slug'=>'salut-les-gens']);
        }, 'posts.show')->with('id','[0-9]+')->with('slug','[a-z\-0-9]+');*/
//$router->post('/posts/:id', "Posts#traitment");
/*$router->post('/post/:id', function($id){echo"poster tous les articles".$id.'<pre>'.print_r($_POST, true).'</pre>';});*/

