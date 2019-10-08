<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\controllers;
use blog\controllers\Controller;
use blog\Renderer;
//use blog\HTTPResponse;
use blog\database\Post;

/**
 * Description of TestFormController
 *
 * @author constancelaloux
 */
class PostsController extends Controller
{
   
    //Je récupére une vue
    public function getPage()
    {
        $render = new Renderer();
        $render->addPath(__DIR__.'/../views');
        return $render->render('Blog');
        //return $this->getrender->render('Blog');
        //$render->addPath('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views');
        //$render->addPath('blog',__DIR__.'/../views');
        //return $render->render('@blog/Blog');
    }

    //Je save des données en bdd
    public function saveIntoDatabase()
    {
        $Post = new Post(); // this creates post object
        $Post->id = '0';
        $Post->title = 'How to cook new pizza';
        $Post->date = time();
        //$Post->finished = false;
        $Post->finished = 'no';
        $Post->body = 'niet';
        //$Post->id = '0';
        $Post->author_id = '1';
        $Post->views = 'rien';

        $Post->save(); // here we construct sql and execute it on the database
    }
    
    //Je récupére des données en bdd
    public function getIntoDatabase()
    {
        $posts = Post::find([
        'title' => 'Some title'
        ]);
    }
    
    /*public function show()
    {
        return $this->getrender()->render();
        //exit("je suis la");
        //$this->app->httpResponse()->redirect('news-'.$request->getData('news').'.html');
        //require (__DIR__ . '/../views/FormAuthorAccessView.php');
        //echo "je suis l article".$id;
        //$test = "/test";
        //$response = new HTTPResponse();
        //$this->httpResponse->redirect('test');
        //$redirect = this->res->redirect('test');
        //$HTTPResponse = new HTTPResponse;
        /*$comment = "test";
        $this->page->addVar('comment', $comment);
        $blog = "Blog";*/
        //$this->setView($blog);
        //$response = $this->page->setContentFile(__DIR__.'/../../Views/Blog.php');
        //$this->send();
        //$response = $HTTPResponse->setPage($this->setView($blog));
        //$response = $HTTPResponse->setPage($this->page());
        //$response = $HTTPResponse->send($response);
        //$this->page->getGeneratedPage('form', $listeNews);
    /*}*/
    
    /*public function traitment() 
    {
        $this->page->addVar('listeNews', $listeNews);
        //print_r($_POST);
        //require (__DIR__ . '/../views/category/Blog.php');
    }*/
}
