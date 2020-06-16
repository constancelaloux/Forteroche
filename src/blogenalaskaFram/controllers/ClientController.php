<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\form\CreateAuthorForm;
use blog\entity\Client;
use blog\database\EntityManager;
use blog\form\ConnectAuthorForm;

/**
 * Description of ClientController
 *
 * @author constancelaloux
 */
class ClientController extends AbstractController
{

    /**
     * Create Client
     */
    public function createClient()
    {
        $title = 'Créer un compte';
        $url = '/createauthor';
        $p = 'Créer un compte';
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
            $client = new Client(
            [
                'surname' => $this->request->postData('surname'),
                'firstname' => $this->request->postData('firstname'),
                'username' => $this->request->postData('username'),
                'password' => $this->request->postData('password'),
            ]);
        }
        else
        {
            $client = new Client();
        }
      
        $formBuilder = new CreateAuthorForm($client);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $password = password_hash($this->request->postData('password'), PASSWORD_DEFAULT);
            $client->setPassword($password);

            $model = new EntityManager($client);

            if($model->exist(['username' => $aclient->username()]))
            {
                unset($model);
                $this->addFlash()->error('Cet identifiant existe déja');
                return $this->redirect('/createclient');
            }
            else
            {
                $model->persist($client);
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
            $client = new Client(
            [
                'username' => $this->request->postData('username'),
                'password' => $this->request->postData('password')
            ]); 
        }
        else 
        {
            $client = new Client();
        }
        
        $formBuilder = new ConnectAuthorForm($client);
        $form = $formBuilder->buildform($formBuilder->form());

        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $model = new EntityManager($client);
            
            if($model->exist(['username' => $client->username()]))
            {
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
}
