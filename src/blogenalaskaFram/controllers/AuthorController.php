<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\form\CreateAuthorForm;
use blog\entity\Author;
use blog\database\EntityManager;
use blog\form\ConnectAuthorForm;

/**
 * Description of TestFormController
 *
 * @author constancelaloux
 */
class AuthorController extends AbstractController
{ 
    
    public function __construct() 
    {
        parent::__construct();
        $this->author = new Author();
    }
    
    /**
    * Create Author
    */
    public function createAuthor()
    {
        $title = 'Créer un compte';
        $url = '/connectform';
        $p = 'Se connecter';
        $this->processForm($title,$url,$p);
    }
    
    /**
     * Je charge une image pour l'uploder
     */
    public function uploadImage()
    {
        $upload = new \blog\file\PostUpload();
        $this->image = $upload->upload($_FILES);
        return $this->image;
    }
    
    /**
     * J'affiche le formulaire et je fais l'appel à la méthode de la base de données
     * @param type $title
     * @return type
     * @throws NotFoundHttpException
     */
    public function processForm($title,$url,$p)
    {
        /**
         * Si il n'y a pas d'id en post ni en get, je créé un nouvel article
         */
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $model = new EntityManager($this->author);
        }
        else
        {
            /**
             * Si il y a un id en post ou en get
             */
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $this->author->setId($id);
            $model = new EntityManager($this->author);
            
            /**
             * Dans le cas ou il n'y pas l'id en base de données
             * Récupère l'objet en fonction de l'@Id (généralement appelé $id)
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
        
        $formBuilder = new CreateAuthorForm($this->author);
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
    * Méthode pour créer le formulaire d'identification
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
                /**
                 * On trouve l'utilisateur corresppondant au username
                 */
                $auth = $model->findOneBy(['username' => $author->username()]);

                /**
                 * On vérifie que l'utilisateur corresponde.
                 */
                /**
                 * On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
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
        $url = '/createauthor';
        $p = 'Pas de compte, s\'enregistrer';
        $this->getrender()->render('FormView', ['title' => $title,'form' => $form->createView(), 'p' => $p, 'url' => $url, 'image' => $author->image()]);     
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

        /**
         * Si il n'y a pas d'id en post ni en get, je créé un nouvel article
         */
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $model = new EntityManager($this->author);
        }
        else
        {
            /**
             * Si il y a un id en post ou en get
             */
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $this->author->setId($id);
            $model = new EntityManager($this->author);
            
            /**
             * Dans le cas ou il n'y pas l'id en base de données
             * Récupère l'objet en fonction de l'@Id (généralement appelé $id)
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
        
        $formBuilder = new CreateAuthorForm($this->author);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if($this->request->method() == 'POST' && $form->isValid())
        {
            $password = password_hash($this->request->postData('password'), PASSWORD_DEFAULT);
            $this->author->setPassword($password);
            $model->persist($this->author);
            $this->addFlash()->success('Votre compte a bien été créé');
            return $this->redirect('/connectform');
        }
        $this->getrender()->render('FormView',['title' => $title,'form' => $form->createView(), 'url' => $url,  'p' => $p]);
   }
}
