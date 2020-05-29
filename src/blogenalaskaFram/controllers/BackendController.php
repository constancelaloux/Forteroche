<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\database\EntityManager;
use blog\entity\Post;
use blog\form\ArticlesForm;
use blog\entity\Comment;

/**
 * Description of BacOfficeController
 * @author constancelaloux
 */
class BackendController extends AbstractController
{
    /**
     * Show posts board
     */
    public function renderHomepage()
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->getrender()->render('BackendhomeView');
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * get Post to show in datatables
     */
    public function getListOfArticles()
    {
        $post = new Post();
        $model = new EntityManager($post);
        // Retrouver tous les articles
        $posts = $model->findAll();

        if (!empty ($posts))
        {
            foreach ($posts as $articles) 
            {
                $row = array();
                $row[] = $articles->id();
                $row[] = $articles->subject();
                $row[] = $articles->createdate()->format('Y-m-d');
                $updateArticleDate = $articles->updatedate();

                if (is_null($updateArticleDate))
                {
                    $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                }
                else 
                {
                    $row[] = $updateArticleDate->format('Y-m-d');
                }

                $row[] = $articles->status();
                $data[] = $row;
            }
                            
            // Structure des données à retourner
            $json_data = array
            (
                "data" => $data
            );
            echo json_encode($json_data);
        }
        else
        {
            $this->getrender()->render('BackendhomeView');
        }
    }
    
    /**
     * Delete post
     */
    public function deletePost()
    {
        if ($this->request->method() == 'POST')
        {  
            //$id = $this->request->postData('id');
            $post = new Post(
            [
                'id' =>  $this->request->postData('id'),
            ]);
            $model = new EntityManager($post);
            $model->remove($post);
        }
    }
    
    /**
     * redirect if post as been well deleted
     * @return type
     */
    public function confirmDeletedPost()
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->addFlash()->success('La news a bien été supprimée !');
            return $this->redirect('/backoffice'); 
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * Create post
     */
    public function createPost()
    {
        $title = "Ecrire un article";
        $this->processForm($title);
        /*if ($this->request->method() == 'POST')
        {
            $post = new Post(
            [
                'subject' =>  $this->request->postData('subject'),
                'content' =>  $this->request->postData('content'),
                'image' =>  $this->request->postData('image'),
                'status' =>  $this->request->postData('validate'),
                'create_date' => date("Y-m-d H:i:s"),
                'update_date' => null,
                'id_author' => 1
            ]);
        }
        else
        {
            $post = new Post();
        }
            
        $formBuilder = new ArticlesForm($post);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {  
            $model = new EntityManager($post);
            $model->persist($post);
            $this->addFlash()->success('La news a bien été ajoutée !');
            return $this->redirect('/backoffice');
        }
        
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);*/
    }
    
    /**
     * Save post
     */
    public function savePost()
    {
        $title = "Ecrire un article";
        $this->processForm($title);
        /*if ($this->request->method() == 'POST')
        {
            $post = new Post(
            [
                'subject' =>  $this->request->postData('subject'),
                'content' =>  $this->request->postData('content'),
                'image' =>  $this->request->postData('image'),
                'status' =>  $this->request->postData('save'),
                'create_date' => date("Y-m-d H:i:s"),
                'update_date' => null,
                'id_author' => 1
            ]);
        }
        else
        {
            $post = new Post();
        }
            
        $formBuilder = new ArticlesForm($post);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {  
            $model = new EntityManager($post);
            $model->persist($post);
            $this->addFlash()->success('La news a bien été ajoutée !');
            return $this->redirect('/backoffice');
        }
        
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);*/
    }
    
    /**
     * Update post
     */
    public function updatePost()
    {
        $title = "Ecrire un article";
        
        $this->processForm($title);
        /*if ($this->request->method() == 'GET')
        {*/
            /*$post = new Post(
            [
                'id' =>  $this->request->getData('id'),
            ]);
            $model = new EntityManager($post);
            $getPostById = $model->findById($post->id());

            if (null === $getPostById) 
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
            else
            {
                if($this->request->method() == 'POST') 
                {
                    $post = new Post(
                    [
                        'id' => $getPostById->id(),
                        'subject' =>  $this->request->postData('subject'),
                        'content' =>  $this->request->postData('content'),
                        'image' =>  $this->request->postData('image'),
                        'status' =>  $this->request->postData('validate'),
                        'create_date' => date("Y-m-d H:i:s"),
                        'update_date' => date("Y-m-d H:i:s"),
                        'id_author' => $getPostById->idauthor()
                    ]);
                }
                
                $formBuilder = new ArticlesForm($getPostById);
                $form = $formBuilder->buildform($formBuilder->form());
                
                if ($this->request->method() == 'POST' && $form->isValid())
                {   
                    $model = new EntityManager($post);
                    $model->persist($post);
                    $this->addFlash()->success('La news a bien été modifié !');
                    return $this->redirect('/backoffice');
                }
                $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
            }*/
    }

    public function processForm($title)
    {
        //Si il n'y a pas d'id en post ni en get, je créé un nouvel article
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $post = new Post();
            $model = new EntityManager($post);
        }
        else
        {
            //Si il y a un id en post ou en get
            //$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $post = new Post(
                [
                    'id' =>  $id,
                ]);
            $model = new EntityManager($post);
            
            //Dans le cas ou il n'y pas l'id en base de données
            // Récupère l'objet en fonction de l'@Id (généralement appelé $id)
            if(!($post = $model->findById($post->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $post->setSubject($this->request->postData('subject'));
            $post->setContent($this->request->postData('content'));
            $post->setImage($this->request->postData('image'));
            $post->setStatus($this->request->postData('validate'));
            $post->setCreatedate(date("Y-m-d H:i:s"));
            $post->setUpdatedate(date("Y-m-d H:i:s"));
            $post->setIdauthor($this->request->postData('idauthor'));
        }
        
        $formBuilder = new ArticlesForm($post);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if($this->request->method() == 'POST' && $form->isValid())
        {
            // On indique l'auteur. Adaptez cela à votre projet, par exemple si vous stockez l'id dans la session.
            //$post->User = $user;
            $model->persist($post);
            if($this->userSession()->requireRole('admin'))
            {
                $this->addFlash()->success('La news a bien été modifié !');
                return $this->redirect('/backoffice');
            }
            else 
            {
                $this->addFlash()->error('Vous n\avez pas acces à cette page!');
                return $this->redirect('/connectform');
            }
        }
        if($this->userSession()->requireRole('admin'))
        {
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
    
    //On va vers la page des commentaires
    public function renderCommentsPage()
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->getrender()->render('CommentsView');
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }  
    }
    
    //On affiche le datatables des commentaires
    public function getListOfComments()
    {
        $comment = new Comment();
        $model = new EntityManager($comment);
        // Retrouver tous les articles
        $comments = $model->findAll();

        if (!empty ($comments))
        {
            foreach ($comments as $comment) 
            {
                $row = array();
                $row[] = $comment->id();
                $row[] = $comment->idpost();
                $row[] = $comment->subject();
                $row[] = $comment->createdate()->format('Y-m-d');
                //$updateCommentDate = $comment->updatedate()->format('Y-m-d');

                if (is_null($comment->updatedate()))
                {
                    $row[] = "Pas de modifications sur ce commentaire pour l'instant";
                }
                else 
                {
                    $row[] = $comment->updatedate()->format('Y-m-d');
                }

                $row[] = $comment->countclicks();
                $data[] = $row;
            }
                            
            // Structure des données à retourner
            $json_data = array
            (
                "data" => $data
            );
            echo json_encode($json_data);
        }
        else
        {
            $this->getrender()->render('CommentView');
        }  
    }
    
    //Je supprime un commentaire du datatables
    public function deleteComments()
    {
        if ($this->request->method() == 'POST')
        {  
            $comment = new Comment(
            [
                'id' =>  $this->request->postData('id'),
            ]);
            $model = new EntityManager($comment);
            $model->remove($comment);
        }
    }
    
    //Je confirme et redirige apres que le commentaire ai été supprimé
    public function confirmDeletedComments()
    {
        if($this->userSession()->requireRole('admin'))
        {
            $this->addFlash()->success('La news a bien été supprimée !');
            return $this->redirect('/listofcomments'); 
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
}
        /*$date = new \DateTime();
        echo $date->format('d/m/Y');
        echo "\n";
        $time = time();
        print_r(date('d/m/Y', $time));*/

        //$this->processForm($title);
            // On récupère l'annonce $id
        /*$advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert) 
        {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }*/

    
    /**
     * Show the form and check if the form is valid
     * @param type $title
     * @return type
     */
    /*public function processForm($title)
    {
        if ($this->request->method() == 'POST')
        {
            $post = new Post(
            [
                'subject' =>  $this->request->postData('subject'),
                'content' =>  $this->request->postData('content'),
                'image' =>  $this->request->postData('image'),
                'status' =>  $this->request->postData('validate'),
                'create_date' => 'NULL',
                //'create_date' => new \Datetime(),
                'update_date' => 'NULL',
                'id_author' => 1
            ]);
        }
        else
        {
            $post = new Post();
        }
            
        $formBuilder = new ArticlesForm($post);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $model = new EntityManager($post);
            if($model->persist($post))
            {
                $this->addFlash()->success('La news a bien été ajoutée !');
                return $this->redirect('/createpost');
            }
        }
        
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
    }*/
