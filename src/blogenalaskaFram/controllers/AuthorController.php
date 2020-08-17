<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\form\CreateAuthorForm;
use blog\form\ConnectAuthorForm;
use blog\exceptions\NotFoundHttpException;

/**
 * Description of AuthorController
 *
 * @author constancelaloux
 */
class AuthorController extends AbstractController
{ 
    public $author;
    public $upload;
    public $authorForm;
    public $connectform;
    
    public function __construct() 
    {
        parent::__construct();
        $this->author = $this->container->get(\blog\entity\Author::class);
        $this->upload = $this->container->get(\blog\file\AuthorUpload::class);
        //$this->authorForm = new CreateAuthorForm($this->author);
        $this->connectForm = new ConnectAuthorForm($this->author);
    }
    
    /**
    * Create Author
    */
    public function createUser()
    {
        $title = 'Créer un compte';
        $url = '/connectform';
        $p = 'Se connecter';
        $this->processForm($title,$url,$p);
    }
    
        
    /**
     * Delete user Method
     */
    public function deleteUser()
    {
        if ($this->request->method() == 'GET')
        {  
            $this->author->setId($this->request->getData('id'));
            $model = $this->getEntityManager($this->author);
            $model->remove($this->author);
            $this->userSession()->logOut();
            $this->addFlash()->success('Votre compte a bien été supprimé');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * Update user Method
     */
   
    public function updateUser()
    {
        $title = 'modifier son profil';
        $url = '/connectform';
        $p = 'Connexion';
        /**
         * If there is no post or get id, I create a new article
         */
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $model = $this->getEntityManager($this->author);
        }
        else
        {
            /**
             * If there is a post id or get id
             */
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $this->author->setId($id);
            $model = $this->getEntityManager($this->author);
            
            /**
             * In case i have no id in database
             * Get object based on Id (usually called $ id)
             */
            if(!($this->author = $model->findById($this->author->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $this->author->setUsername($this->request->postData('username'));
            $this->author->setPassword($this->request->postData('password'));
            $this->author->setImage($this->request->postData('image'));
            $this->author->setSurname($this->request->postData('surname'));
            $this->author->setFirstname($this->request->postData('firstname'));
            if($this->userSession()->requireRole('client'))
            {
                $this->author->setStatus("client");
            }
            else if($this->userSession()->requireRole('admin'))
            {
                $this->author->setStatus("admin");
            }
        }
        
        //$formBuilder = $this->authorForm;
        $formBuilder = new CreateAuthorForm($this->author);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if($this->request->method() == 'POST' && $form->isValid())
        {
            $password = password_hash($this->request->postData('password'), PASSWORD_DEFAULT);
            $this->author->setPassword($password);
                /**
                 * On indique l'auteur. Adaptez cela à votre projet, par exemple si vous stockez l'id dans la session.
                 */
                $model->persist($this->author);
                $this->addFlash()->success('Votre compte a bien été modifié !');
                return $this->redirect('/');
        }
        $this->getrender()->render('FormView', ['title' => $title, 'form' => $form->createView(), 'url' => $url, 'p' => $p, 'image' => $this->author->image()]);
    }
       
    /**
     * I send datas to database even if its a create or an update
     * @param type $title
     * @param type $url
     * @param type $p
     * @return type
     * @throws NotFoundHttpException
     */
    public function processForm($title,$url,$p)
    {
        /**
         * If there is no id in post or get, i create a new author.
         * Si il n'y a pas d'id en post ni en get, je créé un nouvel article
         */
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $model = $this->getEntityManager($this->author);
        }
        else
        {
            /**
             * If there is a post id or a get id
             */
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $this->author->setId($id);
            $model = $this->getEntityManager($this->author);
            
            /**
             * In case there is no id in database
             * I get the object back according to the id
             */
            if(!($this->author = $model->findById($this->author->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $this->author->setUsername($this->request->postData('username'));
            $this->author->setPassword($this->request->postData('password'));
            $this->author->setImage($this->request->postData('image'));
            $this->author->setSurname($this->request->postData('surname'));
            $this->author->setFirstname($this->request->postData('firstname'));
            if($this->userSession()->requireRole('admin'))
            {
                $this->author->setStatus("admin");
            }
            else
            {
                $this->author->setStatus("client");
            }
        }
        
        $formBuilder = new CreateAuthorForm($this->author);
        //$formBuilder = $this->authorForm;
        $form = $formBuilder->buildform($formBuilder->form());
        
        if($this->request->method() == 'POST' && $form->isValid())
        {
            $password = password_hash($this->request->postData('password'), PASSWORD_DEFAULT);
            $this->author->setPassword($password);

            if($model->exist(['username' => $this->author->username()]))
            {
                unset($model);
                $this->addFlash()->error('Cet identifiant existe déja');
                return $this->redirect('/createauthor');
            }
            else
            {
                $model->persist($this->author);
                $this->addFlash()->success('Votre compte a bien été créé');
                return $this->redirect('/connectform');
            }
        }
        $this->getrender()->render('FormView',['title' => $title,'form' => $form->createView(), 'url' => $url,  'p' => $p]);
    }
    
    /**
    * Login Method
    */
    public function logUser()
    {
        if ($this->request->method() == 'POST')
        {
            $this->author->setUsername($this->request->postData('username'));
            $this->author->setPassword($this->request->postData('password'));
        }
        else 
        {
            $this->author;
        }

        $formBuilder = $this->connectForm;
        
        $form = $formBuilder->buildform($formBuilder->form());

        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $model = $this->getEntityManager($this->author);
            
            /**
            * Retrieve user by his username
            */
            if($model->exist(['username' => $this->author->username()]))
            {   /**
                 * We check that the user matches
                 */
                $auth = $model->findOneBy(['username' => $this->author->username()]);
                /**
                 * We check that the data inserted in the form is indeed equivalent to the database datas
                 */
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
        $url = '/createuser';
        $p = 'Pas de compte, s\'enregistrer';
        $this->getrender()->render('FormView', ['title' => $title,'form' => $form->createView(), 'p' => $p, 'url' => $url, 'image' => $this->author->image()]);     
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
    }
    
    /**
     * I get an image for the upload
     */
    public function uploadImage()
    {
        $this->image = $this->upload->upload($_FILES);
        echo "/../../../public/images/upload/user/$this->image";
    }
}
