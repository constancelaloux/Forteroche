<?php

/* 
 *Liste de mes routes à écrire
 */
//$router->get('/', function(){ echo "Bienvenue !"; }); 
$router->get('/', "Posts#getPage");
$router->get('/test', function(){ echo "Bienvenue sur ma homepage !"; }); 
//$router->get('/test/:id-:slug', function($id, $slug)
/*        use($router)
        { 
            //echo "Voila article $slug:$id";   
            echo $router->url('Posts.show', ['id'=>1, 'slug'=>'salut-les-gens']);
        }, 'posts.show')->with('id','[0-9]+')->with('slug','[a-z\-0-9]+');*/
$router->post('/posts/:id', "Posts#traitment");
/*$router->post('/post/:id', function($id){echo"poster tous les articles".$id.'<pre>'.print_r($_POST, true).'</pre>';});*/

