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
use blog\database\test;
use blog\HTML\Form;

/**
 * Description of TestFormController
 *
 * @author constancelaloux
 */
class PostsController extends Controller
{
    
    public function getForm()
    {
        $form = new Form($_POST);
        $form->setFormOpen('myform', ['method'=>'POST']);
        $form->setInput('date', 'name', 'Titre');
        $form->text('person', ['id' => 'span2']);
        $form->password('person2', ['id' => 'span3']);
        $form->date('la date', ['id' => 'span4']);
        //$form->setInput('password', 'password', 'mot de passe');
        $form->setTextarea('text', 'content', 'contenu');
        //$form->setInput('date', 'created_at', 'Date de création');
        $form->setTsubmit('submit', 'Enregistrer');
        $form->setFormClose();

        $render = new Renderer();
        $render->addPath(__DIR__.'/../views');
        $render->render('Blog',[
         'form' => $form
      ]);
        
                //return $render->render('Blog',['form'=>$form->createView()]);
        //return $render->render('Blog',['form'=>$form->getFormOpen(),'button'=>$form->getButton(), 'input'=>$form->getInput(), 'textarea'=>$form->getTextarea()]);
        ////$test = ['nom'=>'jules']
        //print_r(['form'=>$form]);
        //print_r(get_object_vars($form));
                //var_dump( (array) $form);
        /*foreach ($form as $a => $b) 
        {
            print "$a : $b\n";
            die("meurs");
        }*/
    }
   
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
    
    //Je recupere les valeurs de mon formulaire
    public function getValue()
    {    
        print_r($_POST['name']);

        die("meurs");
        $request = new \blog\HTTPRequest();
        if($request ->method() == 'POST')
        {
            $params = $this->getParams($request);
            $this->postTable->insert($params);
            $this->flash->succes("l'article a bien ete ajouté");
            return $this->redirect('/');
        }
    }

    //Je save des données en bdd
    public function saveIntoDatabase()
    {
        $test = 'How to cook new pizza';
        $findTest = test::where('test', '=', $test)->first();
        
        if(is_null($findTest))
        {
            $Post = new test();
            //     ([
            //         'id' => '0',
            //         'test' => 'vive le chocolat'
            //     ]);
            //$Post = new Post(); // this creates post object
            //$Post->id = '0';
            $Post->test = 'How to cook a pizza';
            //$Post->date = time();
            //$Post->finished = false;
            //$Post->finished = 'no';
            //$Post->body = 'niet';
            //$Post->id = '0';
            //$Post->author_id = '1';
           // $Post->views = 'rien';

            $Post->save(); // here we construct sql and execute it on the database
        }
        else
        {
            print_r("je savais bien que ca marcherait cette histoire");
        }
    }
    
    public function saveIntoDatabase2()
    {       
        //print_r("je passe dans celui ci"); 
        $test = new test();
        $test->setAge(3);
        $test->setName('Sally');
        $test->setTest('je fais un test');
        
        $model = new \blog\database\EntityManager();
        $model->persist($test);
        /*$test = new test([
        'id' => '1',
        'test' => 'vive le chocolat'
        ]);*/
        //$test->save();
        //$test->setAgeAttribute(3);
        //echo $test->id;
        //echo $test->test;
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
