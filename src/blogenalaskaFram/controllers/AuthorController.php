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
    public function processForm($title,$url,$p)
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
                //$auth = $model->find(['username' => $author->username()]);
                $auth = $model->findOneBy(['username' => $author->username()]);
                $idOfAuthor = $auth->id();
                //$imageOfAuthor = $author->imageComment();
                $password = $auth->password();
                $username = $auth->username();

                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                $authPassword = password_verify($this->request->postData('password'), $password);        

                if ($authPassword)
                {
                    session_start();
                    $_SESSION['clientUsername'] = $username;
                    $_SESSION['clientPassword'] = $password;
                    $_SESSION['ClientId'] = $idOfAuthor;
                    //$_SESSION['imageComment'] = $imageOfAuthor;
                    $this->addFlash()->success('Vous etes bien enregistrés');
                    return $this->redirect('/backoffice');
                }
                else 
                {
                    $this->addFlash()->success('Votre mot de passe est incorrect!');
                    return $this->redirect('/connectform');
                }          
            }
            else 
            {
                unset($model);
                $this->addFlash()->success('Votre identifiant est incorrect!');
                return $this->redirect('/connectform');
            }
        }
        $title = 'Identifiez vous';
        $p = 'Pas de compte, s\'enregistrer';
        $this->getrender()->render('FormView', ['title' => $title,'form' => $form->createView(), 'p' => $p]);     
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
