<?php

/* 
 *Liste de mes routes à écrire
 */
//Route vers fn qui permet de rediriger vers une vue
$router->get('/', "Posts#redirectView");

//Route vers fn qui permet de rendre une vue
$router->get('/renderView', "Posts#renderView");

//Route vers fn qui permet de laisser un msg flash et rendre une vue
$router->get('/flashMessage', "Posts#FlashMessageAndRenderView");

//Route qui amméne vers la fn qui créé un formulaire de création d'auteur
$router->get('/testFormCreate', "Posts#createMyForm");

//Route qui amméne vers la fn qui valide et gére les données
$router->post('/test', "Posts#getValidateAndSendDatasFromForm");

//Route qui va vers la fonction qui créé un formulaire de connexion
$router->get('/connectForm', "Posts#connectForm");
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
$router->post('/posts/:id', "Posts#traitment");
/*$router->post('/post/:id', function($id){echo"poster tous les articles".$id.'<pre>'.print_r($_POST, true).'</pre>';});*/

