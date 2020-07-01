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
    protected $image = [];
    
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
        /**
         * Retrouver tous les articles
         */
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
                            
            /**
             * Structure des données à retourner
             */
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
     * Je charge une image pour l'uploder
     */
    public function uploadImage()
    {
        $upload = new \blog\file\PostUpload();
        $this->image = $upload->upload($_FILES);
        return $this->image;
    }
    
    /**
     * Create post
     */
    public function createPost()
    {
        $title = "Ecrire un article";
        $this->processForm($title);
    }
    
    /**
     * Save post
     */
    public function savePost()
    {
        $title = "Ecrire un article";
        $this->processForm($title);
    }
    
    /**
     * Update post
     */
    public function updatePost()
    {
        $title = "Ecrire un article";
        
        $this->processForm($title);
    }

    public function processForm($title)
    {
        /**
         * Si il n'y a pas d'id en post ni en get, je créé un nouvel article
         */
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $post = new Post();
            $model = new EntityManager($post);
        }
        else
        {
            /**
             * Si il y a un id en post ou en get
             */
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $post = new Post(
                [
                    'id' =>  $id
                    
                ]);
            $model = new EntityManager($post);
            
            /**
             * Dans le cas ou il n'y pas l'id en base de données
             * Récupère l'objet en fonction de l'@Id (généralement appelé $id)
             */
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
            if($this->request->postData('validate'))
            {
                $post->setStatus($this->request->postData('validate'));
            }
            else if($this->request->postData('save'))
            {
                $post->setStatus($this->request->postData('save'));
            }
            
            if($id)
            {
                $post->setUpdatedate(date("Y-m-d H:i:s"));
            }
            else
            {
                $post->setCreatedate(date("Y-m-d H:i:s"));
            }

            if(!is_null($this->userSession()->user()->id()))
            {
                $post->setIdauthor($this->userSession()->user()->id());
            }
        }
        
        $formBuilder = new ArticlesForm($post);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if($this->request->method() == 'POST' && $form->isValid())
        {
            /**
             * On indique l'auteur. Adaptez cela à votre projet, par exemple si vous stockez l'id dans la session.
             */
            $model->persist($post);
            if($this->userSession()->requireRole('admin'))
            {
                $this->addFlash()->success('L\'article a bien été envoyé !');
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
            $this->getrender()->render('CreateArticleFormView', ['title' => $title, 'form' => $form->createView(), 'image' => $post->image()]);
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
    }
    
    /**
     * On va vers la page des commentaires
     */
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
    
    /**
     * On affiche le datatables des commentaires
     */
    public function getListOfComments()
    {
        $comment = new Comment();
        $model = new EntityManager($comment);
        /**
         * Retrouver tous les articles
         */
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
                            
            /**
             * Structure des données à retourner
             */
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
    
    /**
     * Je supprime un commentaire du datatables
     */
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
    
    /**
     * Je confirme et redirige apres que le commentaire ai été supprimé
     */
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
