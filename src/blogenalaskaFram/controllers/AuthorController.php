<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\form\CreateAuthorForm;
use blog\entity\Author;
use blog\database\EntityManager;
use blog\form\ConnectAuthorForm;

use blog\session\PHPSession;

/**
 * Description of TestFormController
 *
 * @author constancelaloux
 */
class AuthorController extends AbstractController
{ 
    /**
     *
     * @var type 
     */
    //private $session;
    
    /**
     * je fais un session start
     */
    /*public function __construct()
    {
        //$this->session = new ArraySession();
        $this->session = new PHPSession();
    }*/
    
    /**
    * Create Author
    */
    public function createAuthor()
    {
        $title = 'S\'inscrire sur ce site';
        $url = 'connectform';
        $p = 'Connexion';
        $this->processForm($title,$url,$p);
    }
    
    /**
    * Fonction qui va me permettre de créer un formulaire de création d'auteur
     * On passe la méthode createView() du formulaire à la vue
     * afin qu'elle puisse afficher le formulaire toute seule
    */
    /*public function processForm($title,$url,$p)
    { 
        if ($this->request->method() == 'POST')
        {        
            $author = new Author(
            [
                'surname' => $this->request->postData('surname'),
                'firstname' => $this->request->postData('firstname'),
                'username' => $this->request->postData('username'),
                'password' => $this->request->postData('password'),
            ]);
        }
        else
        {
            $author = new Author();
        }
      
        $formBuilder = new CreateAuthorForm($author);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $password = password_hash($this->request->postData('password'), PASSWORD_DEFAULT);
            $author->setPassword($password);

            $model = new EntityManager($author);

            if($model->exist(['username' => $author->username()]))
            {
                unset($model);
                $this->addFlash()->error('Cet identifiant existe déja');
                return $this->redirect('/createauthor');
            }
            else
            {
                $model->persist($author);
                $this->addFlash()->success('Votre compte a bien été créé');
                return $this->redirect('/connectform');
            }
        }
        $this->getRender()->render('FormView', ['title' => $title,'form' => $form->createView(), 'url' => $url, 'p' => $p]);               
    }*/
    
    public function processForm($title)
    {
        //Si il n'y a pas d'id en post ni en get, je créé un nouvel article
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $author = new Author();
            $model = new EntityManager($author);
        }
        else
        {
            //Si il y a un id en post ou en get
            //$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $author = new Author(
                [
                    'id' =>  $id,
                ]);
            $model = new EntityManager($author);
            
            //Dans le cas ou il n'y pas l'id en base de données
            // Récupère l'objet en fonction de l'@Id (généralement appelé $id)
            if(!($author = $model->findById($author->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $author->setUsername($this->request->postData('username'));
            $author->setPassword($this->request->postData('password'));
            //$author->setImage($this->request->postData('image'));
            $author->setSurname($this->request->postData('surname'));
            $author->setFirstname($this->request->postData('firstname'));
            $author->setStatus("null");
        }
        
        $formBuilder = new CreateAuthorForm($author);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if($this->request->method() == 'POST' && $form->isValid())
        {
            $password = password_hash($this->request->postData('password'), PASSWORD_DEFAULT);
            $author->setPassword($password);

            if($model->exist(['username' => $author->username()]))
            {
                unset($model);
                $this->addFlash()->error('Cet identifiant existe déja');
                return $this->redirect('/createauthor');
            }
            else
            {
                $model->persist($author);
                $this->addFlash()->success('Votre compte a bien été créé');
                return $this->redirect('/connectform');
            }
        }
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
    }
    
    /**
    * Fonction pour créer le formulaire d'identification
    */
    public function logAuthor()
    {
        if ($this->request->method() == 'POST')
        {
            $author = new Author(
            [
                'username' => $this->request->postData('username'),
                'password' => $this->request->postData('password')
            ]); 
        }
        else 
        {
            $author = new Author();
        }
        
        $formBuilder = new ConnectAuthorForm($author);
        $form = $formBuilder->buildform($formBuilder->form());

        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $model = new EntityManager($author);
            
            if($model->exist(['username' => $author->username()]))
            {   
                //On trouve l'utilisateur corresppondant au username
                $auth = $model->findOneBy(['username' => $author->username()]);
                //print_r($author->username());
                //die("meurs");

                //On vérifie que l'utilisateur corresponde.
                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                $authPassword = password_verify($this->request->postData('password'), $auth->password());        

                if ($authPassword)
                {
                    if(session_status() === PHP_SESSION_NONE)
                    {
                        session_start();
                    }
                    
                    $_SESSION['authorUsername'] = $auth->username();
                    $_SESSION['authorId'] = $auth->id();
                    $_SESSION['status'] = $auth->status();
                    //$_SESSION['imageComment'] = $imageOfAuthor;
                    //$this->userSession()->setUser($auth->status());
                    //$this->userSession()->setUser($auth->id());
                    //$this->userSession()->setUser($auth->username());
                    //print_r($this->userSession()->setUser($auth->status()));
                    //die("meurs");
                    
                    if($this->userSession()->requireRole('admin'))
                    {
                        $this->addFlash()->success('Vous etes bien identifié');
                        return $this->redirect('/backoffice');
                    }
                    elseif ($this->userSession()->requireRole('client')) 
                    {
                        $this->addFlash()->success('Vous etes bien identifié');
                        return $this->redirect('/');
                    }
                    else 
                    {
                        $this->addFlash()->error('Vous n\avez pas acces à cette page!');
                        return $this->redirect('/connectform');
                    }
                }
                else 
                {
                    $this->addFlash()->error('Votre mot de passe est incorrect!');
                    return $this->redirect('/connectform');
                }          
            }
            else 
            {
                unset($model);
                $this->addFlash()->error('Votre identifiant est incorrect!');
                return $this->redirect('/connectform');
            }
        }
        $title = 'Identifiez vous';
        $p = 'Pas de compte, s\'enregistrer';
        $this->getrender()->render('FormView', ['title' => $title,'form' => $form->createView(), 'p' => $p]);     
    }
    
    /*
     * Méthod to logOut the user
     */
    public function logOut()
    {
        $this->userSession()->logOut();
        if(!session_id('authorId'))
        {
            $this->addFlash()->success('Vous étes déconnectés');
            return $this->redirect('/connectform');
        }
        else
        {
            $this->addFlash()->success('Vous n\'étes pas déconnectés');
            return $this->redirect('/backoffice');
        } 
        /*if($this->userSession()->logOut())
        {
            if(session_id('authorId'))
            {
                //print_r($_SESSION);
                die("meurs la ");
            }
            else 
            {
                //print_r($_SESSION["authorId"]);
                //die("meurs");
            }
            $this->addFlash()->success('Vous étes déconnectés');
            return $this->redirect('/connectform');
        }
        else
        {
            //print_r($_SESSION);
            $this->addFlash()->success('Vous n\'étes pas déconnectés');
            return $this->redirect('/backoffice');
        } */
    }
    
    /**
     * Method delete user
     */
    public function deleteUser()
    {
        if ($this->request->method() == 'GET')
        {  
            $author = new Author(
            [
                'id' =>  $this->request->getData('id'),
            ]);
            $model = new EntityManager($author);
            $model->remove($author);
            $this->addFlash()->success('Votre compte a bien été supprimé');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * Méthode uodate user
     */
   public function updateUser()
   {
        $title = 'modifier son profil';
        $url = 'connectform';
        $p = 'Connexion';
        $this->processForm($title,$url,$p);
   }
    
    
    
    
    
    
    
    
    
    
   
   
   
   
   
   
    //Fonction qui permet d'effectuer une redirection vers l'url du form de création d'un auteur
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
    

    
    //Fonction qui va valider les données et les récupérer les données du formulaire. 
    //Puis ensuite les envoyer en base de données.
    public function getValidateAndSendDatasFromForm()
    {    
        //print_r($this->form);
        if ($this->request->method() == 'POST' && $this->form->isValid())
        {
            //print_r($this->form->isValid());
            //die("meurs");
            $authorSurname = $this->request->postData('surname');
            $authorFirstname = $this->request->postData('firstname');
            $authorUsername = $this->request->postData('username');
            $authorPassword = $this->request->postData('password');

            $author = new Author(
            [
                'surname' => $authorSurname,
                'firstname' => $authorFirstname,
                'username' => $authorUsername,
                'password' => password_hash($authorPassword, PASSWORD_DEFAULT)
            ]);
            
            $model = new EntityManager($author);
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
    

    
    //Fonction pour valider la connexion de l'auteur.
    //check if the username and the password has been set
    public function validateConnexion()
    {
        if ($this->request->method() == 'POST' && $this->form->isValid())
        {
            $authorUsername = $_POST['username'];
            $authorPassword = $_POST['password'];
            
            $author = new Author(
            [
                'username' => $authorUsername,
                'password' => $authorPassword
            ]); 

            $model = new EntityManager($author);

            if($model->exist(['username' => $author->getUsername()]))
            {
                $author = $model->find(['username' => $author->getUsername()]);

                $idOfAuthor = $author->getId();
                //$imageOfAuthor = $author->imageComment();
                $password = $author->getPassword();
                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                $authPassword = password_verify($authorPassword, $password);                  

                if ($authPassword)
                {
                    session_start();
                    $_SESSION['clientUsername'] = $authorUsername;
                    $_SESSION['clientPassword'] = $password;
                    $_SESSION['ClientId'] = $idOfAuthor;
                    //$_SESSION['imageComment'] = $imageOfAuthor;
                    return $this->redirect('/authorFrontPage');
                }
                else 
                {
                    print_r('Votre mot de passe est incorrect!');
                    //throw new Exception('Votre mot de passe est incorrect!');
                }
            }
        }
    }
    
    //Je récupére la premiére page de mon blog
    public function getAuthorFrontPage()
    {
        return $this->getrender()->render('AuthorFrontPage'); 
    }
}
