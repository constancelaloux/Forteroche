<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\Validator;
use blog\form\CreateAuthorForm;
use blog\database\Author;
use blog\database\Manager;
use blog\form\ConnectForm;
/**
 * Description of TestFormController
 *
 * @author constancelaloux
 */
class AuthorController extends AbstractController
{
    //Fonction qui permet de rendre la vue
    public function renderView()
    {
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
        $formBuilder = new CreateAuthorForm();
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
        $this->getrender()->render('ConnectForm', ['title' => $title,'form' => $form->createView()]);     
    }
    
    public function validateConnexion()
    {
        if ($this->request->method() == 'POST' && $this->form->isValid())
        {
            //check if the username and the password has been set
            $authorUsername = $_POST['username'];
            $authorPassword = $_POST['password'];
            
            $author = new Author(
            [
                'username' => $authorUsername,
                'password' => $authorPassword
            ]); 

            $model = new Manager($author);

            if($model->exist(['username' => $author->getUsername()]))
            {
                // Appel d'une fonction de cet objet
                $author = $model->find(['username' => $author->getUsername()]);

                $idOfAuthor = $author->getId();
                //$imageOfAuthor = $author->imageComment();
                $password = $author->getPassword();
                //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
                $authPassword = password_verify($authorPassword, $password);                  

                if ($authPassword)
                {
  
                    // Start the session
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
