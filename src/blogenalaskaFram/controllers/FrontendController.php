<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\form\CommentsForm;
use blog\database\Query;
use blog\Paginate;
use blog\exceptions\NotFoundHttpException;

/**
 * Description of FrontendController
 * @author constancelaloux
 */
class FrontendController extends AbstractController
{
    public $perPage;
    
    public $post;
    
    public $comment;
    
    public $author;
    
    public $paginateQuery;
    
    public $previousLink;
    
    public $nextLink;
    
    public $commentForm;
    
    public $paginatedQueryPost;
    
    public $paginateQueryComment;
    
    public function __construct() 
    {
        parent::__construct();
        $this->post = $this->container->get(\blog\entity\Post::class);
        $this->comment = $this->container->get(\blog\entity\Comment::class);
        $this->author =  $this->container->get(\blog\entity\Author::class);
        //$this->commentForm = new CommentsForm($this->comment);
        //$this->paginatedQueryPost = new Paginate($this->post, $this->perPage);
        //$this->paginateQueryComment = new Paginate($this->comment, $this->perPage);
        //new Query($this->comment, $this->author)
    }
    
    /*
     * Function which render the home page
     */
    public function renderhomepage()
    {
        return $this->redirect("/articles:page=1");
    }
    
    /**
     * Paginate and render posts
     */
    public function renderPaginatedPosts()
    {
        /**
         * Get the lasts posts
         */
        $lastsposts = $this->getLastsPosts();
        /**
         * Paginate
         */
        $model = $this->getEntityManager($this->post);
        $this->perPage = 9;
        $this->paginatedQueryPost = new Paginate($this->post, $this->perPage);
        $offset = $this->paginatedQueryPost->getItems();
        $posts = $model->findBy($filters = NULL, [$orderBy = 'create_date'], $limit = $this->perPage, $offset = $offset);
        $previouslink = $this->paginatedQueryPost->previouslink();
        $nextlink = $this->paginatedQueryPost->nextlink();
        $this->getrender()->render('FrontendhomeView',['posts' => $posts, 'previouslink' => $previouslink, 'nextlink' => $nextlink, 'lastsposts' => $lastsposts]);
    }
    
    /*
     * Function to the article page
     */
    public function renderPost()
    {
        /**
         * I show the comments
         */
        $comment = $this->renderPaginatedComments($_GET['id']);
        
        /**
         * Get the lasts posts
         */
        $lastsposts = $this->getLastsPosts();
        
        /**
         * Show the form to write the comments
         */
        //$commentform = $this->createComment();
        $commentform = $this->processForm();
        
        /**
         * Show posts depends of id
         */
        $postFromId = $this->getPost($_GET['id']);
        
        /**
         * Show the page with all the components
         */
        $this->getrender()->render('ArticleView', ['post' => $postFromId, 'lastsposts' => $lastsposts, 'form' => $commentform, 'previouslink' => $this->previousLink, 'nextlink' => $this->nextLink, /*'posts' => $posts,*/ 'comments' => $comment]);
    }
    
    /**
     * I will get the lasts three posts
     */
    public function getLastsPosts()
    {
        $model = $this->getEntityManager($this->post);
        $lastsposts = $model->findBy($filters = NULL, [$orderBy = 'create_date'], $limit = 3, $offset = 0);
        return $lastsposts;
    }

    /**
     * I show the post from the id and its pagination
     * @param type $id
     * @return type
     */
    public function getPost($id)
    {
        $model = $this->getEntityManager($this->post);
        return $postFromId = $model->findById($id);
    }
    
    /**
     * Show comments from the post id
     */
    public function renderPaginatedComments($id)
    {
        $query = NULL;
        $this->perPage = 5;
        $this->paginateQueryComment = new Paginate($this->comment, $this->perPage);
        $offset = $this->paginateQueryComment->getItems();
        
        $this->comment->setIdpost($id);
        $this->comment->setStatus('Valider');
        $model = $this->getEntityManager($this->comment);
        
        if($model->exist(['idpost'=>$this->comment->idpost()]))
        { 
            $comments = $query = (new Query($this->comment, $this->author))
                    ->from('comment', 'c')
                    ->select('c.id id','c.subject subject', 'a.image image', 'c.id_client id_client', 'a.username username','c.create_date create_date','c.update_date update_date', 'c.content content', 'c.countclicks countclicks')
                    ->join('author as a', 'c.id_client = a.id', 'inner')
                    ->where('id_post = :idpost')
                    ->setParams(array('idpost' => $this->comment->idpost()))
                    ->orderBy('create_date', 'ASC')
                    ->limit($this->perPage, $offset)
                    ->fetchAll();
            $this->previousLink = $this->paginateQueryComment->previouslink();
            $this->nextLink = $this->paginateQueryComment->nextlink();
            return $comments;
        }
    }
    
    /**
     * I send into the database the reports and i increment each time when we click on the picture
     */
    public function unwantedComment()
    {
        $number = $_POST['number'];
        $model = $this->getEntityManager($this->comment);
        $comment = $model->findById($_POST['id']);

        if (!empty ($comment))
        {
            $clicks = $comment->countclicks();
        }
        $clicksIncremented = $clicks + $number;
        $this->comment->setCountclicks($clicksIncremented);
        $this->comment->setId($comment->id());
        $model->persist($this->comment);
    }
    /*
     * Create comment
     */
    public function createComment()
    {
        return $this->processForm();
    }
    
    /*
     * Modify comment
     */
    public function updateComment()
    {
        if($this->userSession()->requireRole('client', 'admin'))
        {
            $this->processForm();
        }
        else
        {
            $this->addFlash()->error('Vous ne pouvez pas modifier ce commentaire!');
            $id = $this->request->postData('idpost');
            return $this->redirect("/article&id=$id");
        }
    }

    /**
     * I show the form and i call the function to send the comments in database
     * @return type
     * @throws NotFoundHttpException
     */
    public function processForm()
    { 
        /**
         * If there is no post or get id, i create a new comment
         */
        if(is_null($this->request->getData('idcomment')) && is_null($this->request->postData('idcomment')))
        {
            $model = $this->getEntityManager($this->comment);
        }
        else
        {
            /**
             * If there is a post id or get id
             */
            $idComment = $this->request->postData('idcomment') ? $this->request->postData('idcomment') : $this->request->getData('idcomment');
            $this->comment->setId($idComment);
            $model = $this->getEntityManager($this->comment);
            
            /**
             * In case i have no id in database, i get the object from the id(call $id)
             */
            if(!($this->comment = $model->findById($this->comment->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$idComment." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $this->comment->setSubject($this->request->postData('subject'));
            $this->comment->setContent($this->request->postData('content'));
            $this->comment->setStatus($this->request->postData('validate'));
            
            if(isset($idComment))
            {
                $this->comment->setUpdatedate(date("Y-m-d H:i:s"));
            }
            else
            {
                $this->comment->setCreatedate(date("Y-m-d H:i:s"));
            }
            
            $this->comment->setCountclicks(NULL);

            if(!is_null($this->userSession()->user()->id()))
            {
                $this->comment->setIdclient($this->userSession()->user()->id());
            }
            
            $this->comment->setIdpost($this->request->postData('idpost'));
        }
        
        //$formBuilder = $this->commentForm;
        $formBuilder = new CommentsForm($this->comment);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $model = $this->getEntityManager($this->comment);
            $model->persist($this->comment);
            $this->addFlash()->success('Votre commentaire a bien été ajoutée !');
            //$id = $this->request->postData('idpost');
            $id = $this->request->getData('id');
            if(!is_null($this->request->getData('idcomment')))
            {   
                $id = $this->request->getData('id');
                return $this->redirect("/article&id=$id&idcomment=$idComment");
            }
            else
            {
                return $this->redirect("/article&id=$id");
            }
            //return $this->redirect("/article&id=$id");
        }
        if($this->userSession()->requireRole('client', 'admin'))
        {
            return $form->createView(); 
        }
        else 
        {
            return $this->addFlash()->error('Veuillez vous inscrire pour ajouter un commentaire!');
        }
        /*if($this->userSession()->requireRole('client', 'admin'))
        {*/
        /*}
        else 
        {
            return $this->addFlash()->error('Veuillez vous inscrire pour ajouter un commentaire!');
        }*/
            //die('meurs');
            //return $formView = $form->createView();
            //return $this->redirect("/article&id=$id&form=$formView");
        
        //}
        //return $form->createView();
                        //return $this->redirect("/article&id=$id&idcomment=$idComment");
            /*if(!is_null($this->request->getData('idcomment')))
            {   
                $id = $this->request->getData('id');
                return $this->redirect("/article&id=$id&idcomment=$idComment");
            }
            else
            {
                return $this->redirect("/article&id=$id");
            }*/
    }
    
    /*
     * Delete comment
     */
    public function deleteComment()
    {
        if ($this->request->method() == 'POST')
        {
            if($this->userSession()->requireRole('client', 'admin'))
            {
                $this->comment->setId($this->request->getData('idcomment'));
                $model = $this->getEntityManager($this->comment);
                $model->remove($this->comment);
                $this->addFlash()->error('Votre commentaire a été supprimé!');
                $postid = $this->request->getData('id');
                return $this->redirect("/article&id=$postid");
            }
            else
            {
                $this->addFlash()->error('Vous ne pouvez pas supprimer ce commentaire!');
                $postid = $this->request->getData('id');
                return $this->redirect("/article&id=$postid");
            }
        }  
    }
    
    /**
     * Redirect to main page with a success message after submit the email form
     * @return type
     */
    public function sendEmailToAuthor()
    {
        $this->addFlash()->success('Votre email a bien été envoyé!');
        return $this->redirect("/articles:page=1");
    }
}
