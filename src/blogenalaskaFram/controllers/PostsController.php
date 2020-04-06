<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\controllers;
use blog\controllers\AbstractController;
use blog\Validator;
//use blog\HTML\Renderer;
//use blog\HTTPResponse;
//use blog\database\Post;
//use blog\database\test;
//use blog\HTML\Form3;
//use blog\HTML\StringField;
//use blog\HTML\TextField;
//use blog\HTML\FormBuilder;
use blog\form\TestForm;
//use blog\session\PHPSession;
use blog\database\Author;
use blog\database\Manager;
use blog\HTML\ConnectForm;
/**
 * Description of TestFormController
 *
 * @author constancelaloux
 */
class PostsController extends AbstractController
{
    //Fonction qui permet de rendre la vue
    public function renderView()
    {
        //print_r("je passe la");
        //$render = $this->getRender()->addPath(__DIR__.'/../views');
        return $this->getRender()->render('test',[
         'password' => 'voici mon test',
         //'password' => $form,
         //'text' =>['name' => '<strong>Mathieu</strong>', 'age' => '13'],
         'stuff' => array(
            array(
                'Thing' => "roses",
                'Desc' => "Red",
            ),
            array(
                'Thing' => "tree",
                'Desc' => "green",
            ),
            array(
                'Thing' => "Sky",
                'Desc' => "blue",
            ),
        )
      ]);
        die("meurs");  
    }
    
    //Fonction qui permet d'effectuer une redirection vers une nouvelle url
    public function redirectView()
    {
        return $this->redirect('/testFormCreate');
    }
    
    //Fonction de rendre une vue avec un msg flash en paramétre
    public function FlashMessageAndRenderView()
    {
        $this->addFlash()->success('L\'article a bien été ajouté');
        if($this->getFlash('success'))
        {
            $flashMessageSuccess = $this->getFlash('success');
            return $this->getrender()->render('TestSessionFlahMessages',  ['message' => $flashMessageSuccess]);
        }
    }
    
    //Fonction qui va me permettre de créer un formulaire de création d'auteur
    public function createMyForm()
    { 
        //On créé le formulaire
        $title = 'mon formulaire de test';
        $formBuilder = new TestForm();
        $form = $formBuilder->buildform($formBuilder->form());
        $url = 'connectForm';
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        $this->getrender()->render('Form', ['title' => $title,'form' => $form->createView(), 'url' => $url]);                
    }
    
    //Fonction qui va valider les données et les récupérer les données du formulaire. 
    //Puis ensuite les envoyer en base de données.
    public function getValidateAndSendDatasFromForm()
    {      
        if ($this->request->method() == 'POST' && $this->form->isValid())
        {
            $authorSurname = $this->request->postData('surname');
            $authorFirstname = $this->request->postData('firstname');
            $authorUsername = $this->request->postData('username');
            $authorPassword = $this->request->postData('password');

            //On créé notre objet Author
            $author = new Author(
            [
                'surname' => $authorSurname,
                'firstname' => $authorFirstname,
                'username' => $authorUsername,
                'password' => password_hash($authorPassword, PASSWORD_DEFAULT)
            ]);
            
            //username = Jean_Forteroche
            //password = @jeanF38
            $model = new Manager($author);
            if($model->exist(['username' => $author->getUsername()]))
            {
                unset($model);
                return $this->redirect('/testFormCreate');
            }
            else
            {
                $model->persist($author);
                $this->addFlash('Votre compte a bien été créé');
                //return $this->getFlash('success');
                return $this->redirect('/connectForm');
            }
        }
        else
        {
            die("je meurs parce que je ne correspond pas à ce qui est demandé");
        }
    }
    
    //Fonction pour créer le formulaire d'identification
    public function connectForm()
    {
        //On créé le formulaire
        $title = 'Veuillez entrer votre mot de passe et votre identifiant';
        $formBuilder = new ConnectForm();
        $form = $formBuilder->buildform($formBuilder->form());
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        $this->getrender()->render('ConnectForm', ['title' => $title,'form' => $form->createView()]);
    }

    
    
    
    
    
    
    
    
    
    
    
    
    //Test de validator. Valider les informations
    public function validateInformations()
    {
        $validator = new Validator($params);
        $validator->required('name', 'content');
        $validator->slug('slug');
        $validator->dateTime('created_at');
        $validator->minLength(8);
    }
    
    //Fonction qui permet de save des données dans l'orm
    public function saveTestIntoDatabase()
    {
        $test = new test();
        //$test->setId('1');
        $test->setAge(3);
        $test->setName('Sally');
        $test->setTest('je fais un test');
        $test->setCreateDate('1985-12-1');
        //$validator = new \blog\Validator();
        //$validator = $this->getValidator($request);
        $validator = new \blog\Validator();
        if($validator->is_valid())
        {
            $model = new \blog\database\Manager($test);
            //print_r('je vais aller dans persist');
            $model->persist($test);
            
            //Je vais vers la vue pour afficher mon message flash
            //$render = new Renderer();
            //$this->session = new PHPSession();
            //$this->session->set('success', 'L\'article a bien été ajouté');
            //$session = new \blog\session\ArraySession();
            $this->flash = new FlashService();
            $this->flash->success('L\'article a bien été ajouté');
            
            $render = $this->getRender()->addPath(__DIR__.'/../views');
            //if($this->session->get('success'))
            if($this->flash->get('success'))
            {
                //$session = $this->session->get('success');
                $session = $this->flash->get('success');
                $render = $this->getRender()->render('TestSessionFlahMessages');
                return $render;
                //$render = $this->getRender()->render('TestSessionFlahMessages',  ['message' => $session]);
                //return $this->getrender()->render('TestSessionFlahMessages',  ['message' => $session]);
            }
            //$this->flash->success('Le test a bien été inséré en base de données');
            //return $this->redirect('blog.admin.index');
        }
        $errors = $validator->getErrors();
        //return $this->renderer->render('@blog/admin/edit', compact('item', 'errors'));
        //$manager = new \blog\database\DbConnexion();
        //$manager = $manager->getManager(test::class);
    }
    
    //Je créé un formulaire
    public function getForm()
    {
        $form = new Form($_POST);
        $form->text('person', ['id' => 'span2']);
        $form->password('person2', ['id' => 'span3']);
        $form->date('la date', ['id' => 'span4']);
        $form->setTextarea('text', 'content', 'contenu');
        $form->setTsubmit('submit', 'Enregistrer');
        $form->setFormClose();
        $data = array(

           //"titre" => "Seconde page",
           "pays" => array(
               0 => array(
                   "regions" => array(
                       0 => array(
                           "nom" => "Nord",
                           "numero" => "59"
                       ),
                       1 => array(
                           "nom" => "Oise",
                           "numero" => "60"
                       ),
                   ),
                   "nom" => "France"
               ),
               1 => array(
                   "regions" => array(
                       0 => array(
                           "nom" => "Flamand",
                           "numero" => "Y'en a ?"
                       ),
                       1 => array(
                           "nom" => "Wallons",
                           "numero" => "Je sais pas.."
                       ),
                   ),
                   "nom" => "Belgique"
               )
           )
        ); 
        $render = new Renderer();
        //$render = new \blog\HTML\Template(__DIR__.'/../views/template.html');
        $render->addPath(__DIR__.'/../views');
        $render->render('test',[
         'password' => 'voici mon test',
         //'password' => $form,
         //'text' =>['name' => '<strong>Mathieu</strong>', 'age' => '13'],
         'stuff' => array(
            array(
                'Thing' => "roses",
                'Desc' => "Red",
            ),
            array(
                'Thing' => "tree",
                'Desc' => "green",
            ),
            array(
                'Thing' => "Sky",
                'Desc' => "blue",
            ),
        )
      ]);
        
                    //print_r($request->method());
            //$params = $this->getParams($request);
            //$author = new Author($params);
            //print_r($author);
            //die("meurs");
            //print_r($request->postData('username'));
            //die("j'ai bien été validé");
            //print_r($author);
            //$username = 'username';
            //$getUsername = $author->getUsername();
            //print_r($getUsername);
            //$test = [$username, $getUsername];
        
            /*if($model->exists($test))
            {
                print_r("j'ai deja ces identifiants en bdd");
            }
            else
            {*/
            //}

        //$render->assign('password', 'hé oui sayé ceci est un test');
        //$render->assign('text', ['name' => '<strong>Mathieu</strong>', 'age' => '13']);
        //$render->show();
        
        //$render->render('newhtml'
        //);
        
                //$htmlBuilder = new \blog\HTML\);
        //$result4 = $htmlBuilder->tag(['form' => $form]);
                //$form->setInput('date', 'created_at', 'Date de création');
                //$form->setInput('password', 'password', 'mot de passe');
                //$form->add('content',   TextareaType::class);
        //$form->open(['action' => 'newaction','method' => 'POST', 'class' => 'form', 'id' => 'id-form']);
        //$form->setFormOpen('myform', ['method'=>'POST']);
        //$form->setInput('date', 'name', 'Titre');
        
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
        die("meurs");
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
    
            //$formBuilder = new FormBuilder();
        //$form = $formBuilder->createView(TestForm::class);
        /*$form = new Form3();
    
        $form->add(new StringField([
            'label' => 'Auteur',
            'name' => 'auteur',
            'maxLength' => 50,
           ]))
           ->add(new TextField([
            'label' => 'Contenu',
            'name' => 'contenu',
            'rows' => 7,
            'cols' => 50,
           ]));*/
        //$view = $form->createView();
    
        //Fonction qui va me permettre de créer un formulaire
    public function CreateNewForm()
    {
        /*$form = new Form();
        $form->open([ 'action' => '/test','method' => 'POST']);
        $form->label('username','Identifiant');
        $form->text('login', null, ['class' => 'span2']);
        $form->label('password','Mot de passe');
        $form->password('pass', ['id' => 'span3']);
        $form->submit('Envoyer');
        $form->close();*/
        //print_r($form);
        //$formBuilder->createView($form);
        //$open = $this->createForm()->open(['method' => 'POST', 'class' => 'form', 'id' => 'id-form']);
        //$surname = $this->createForm()->text('surname', null, ['class' => 'span2']);
        //$firstname = $this->createForm()->text('firstname', null, ['class' => 'span2']);
        $openForm = $this->CreateForm()->open([ 'action' => '/test','method' => 'POST']);
        $label1 = $this->CreateForm()->label('username','Identifiant');
        $username = $this->createForm()->text('login', null, ['class' => 'span2']);
        $label2 = $this->CreateForm()->label('password','Mot de passe');
        $password = $this->createForm()->password('pass', ['id' => 'span3']);
        $submitbutton = $this->createForm()->submit('Envoyer');
        $closeForm = $this->createForm()->close();
        //$formBuilder = new \blog\HTML\FormBuilder();
        //$formBuilder->createView();
        //$//this->createForm()->date('la date', ['id' => 'span4']);
        //$submitbutton = $this->createForm()->submit('Envoyer');
        //$this->createForm()->setTextarea('text', 'content', 'contenu');
        //$this->createForm()->setTsubmit('submit', 'Enregistrer');
        //$this->createForm()->setFormClose();
        //print_r($password);
        return $this->getrender()->render('Form', ['form' =>['openForm' => $openForm, 'labelusername' => $label1,'username' => $username, 'labelpassword' => $label2, 'password' => $password, 'submitButton' => $submitbutton, 'closeForm' => $closeForm]]);
    }
}
