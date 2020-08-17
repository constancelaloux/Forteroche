<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\form\CommentsForm;
use blog\database\Query;
use blog\Paginate;
use blog\exceptions\NotFoundHttpException;
use blog\service\PostService;
use blog\service\CommentService;
use blog\entity\Author;
use blog\database\EntityManager;

/**
 * Description of FrontendController
 * @author constancelaloux
 */
class FrontendController extends AbstractController
{
    protected $perPage;
    
    protected $post;
    
    protected $comment;
    
    protected $author;
    
    protected $paginateQuery;
    
    protected $previousLink;
    
    protected $nextLink;
    
    protected $commentForm;
    
    protected $paginatedQueryPost;
    
    protected $paginateQueryComment;
    
    protected $postService;
    
    protected $commentService;
    
    public function __construct() 
    {
        parent::__construct();
        $this->post = $this->container->get(\blog\entity\Post::class);
        $this->comment = $this->container->get(\blog\entity\Comment::class);
        $this->author =  $this->container->get(\blog\entity\Author::class);
        $this->postService = new PostService();
        $this->commentService = new CommentService();
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
    
    public function renderPaginatedPosts()
    {
         return $this->postService->renderPaginatedPosts();
    }
    
    public function renderPaginatedComments($id)
    {
        $comment = new \blog\entity\Comment();
        $author = new Author();
        $this->perPage = 5;
        $comment->setIdpost($id);
        $comment->setStatus('Valider');
        $commentEntityManager = new EntityManager($comment);
        $countItems = $commentEntityManager->exist(['idpost'=>$comment->idpost()]);
        $paginateQueryComment = new Paginate($comment, $this->perPage, $countItems);
        $offset = $paginateQueryComment->getItems();
        
        if($commentEntityManager->exist(['idpost'=>$comment->idpost()]))
        { 
            $comments = $query = (new Query($comment, $author))
                    ->from('comment', 'c')
                    ->select('c.id id','c.subject subject', 'a.image image', 'c.id_client id_client', 'a.username username','c.create_date create_date','c.update_date update_date', 'c.content content', 'c.countclicks countclicks')
                    ->join('author as a', 'c.id_client = a.id', 'inner')
                    ->where('id_post = :idpost')
                    ->setParams(array('idpost' => $comment->idpost()))
                    ->orderBy('create_date', 'ASC')
                    ->limit($this->perPage, $offset)
                    ->fetchAll();
            $this->previousLink = $paginateQueryComment->previouslink();
            $this->nextLink = $paginateQueryComment->nextlink();
            $array = [$comments, $this->nextLink, $this->previousLink];
            return $array;
        }
    }
    
    /*
     * Function to the article page
     */
    public function renderPost()
    {
        //Tester les deux dans une methode de abstract controller
        /**
         * Test if post and get method are not null
         */
        (!is_null($this->request->getData('idcomment')) && $idcomment = $this->request->getData('idcomment'));
        
        /**
         * I show the comments
         */
        $comment = $this->renderPaginatedComments($_GET['id']);
        
        if (is_null($comment))
        {
            $comment[0] = null;
            $comment[1] = 1;
            $comment[2] = 1;
        }

        /**
         * Get the lasts posts
         */
        $lastsposts = $this->postService->getLastsPosts();

        //Si je suis en session j'affiche le formulaire sinon j'affiche un message flach à la place
        if($this->userSession()->requireRole('client', 'admin'))
        {
            print_r('j affiche le formulaire');
            /**
             * Show the form to write the comments
             */
            if(isset($idcomment))
            {
                $commentform = $this->commentService->updateComment($idcomment);
            }
            else
            {
                $commentform = $this->commentService->createComment();
            }
        }
        else 
        {
            $commentform = $this->addFlash()->error('Veuillez vous inscrire pour ajouter un commentaire!');
        }

        /**
         * Show posts depends of id
         */
        $postFromId = $this->postService->getPost($_GET['id']);
        
        /**
         * Show the page with all the components
         */
        if($commentform === true )
        {
            return $this->redirect("/");
        }

        $title = 'Ecrire un commentaire';
        $this->getrender()->render('ArticleView', ['post' => $postFromId, 'lastsposts' => $lastsposts, 'form' => $commentform, 'previouslink' => $comment[2], 'nextlink' => $comment[1], /*'posts' => $posts,*/ 'comments' => $comment[0], 'title' => $title]);
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
                return $this->redirect("/article&id=$postid&page=1");
            }
            else
            {
                $this->addFlash()->error('Vous ne pouvez pas supprimer ce commentaire!');
                $postid = $this->request->getData('id');
                return $this->redirect("/article&id=$postid");
            }
        }  
    }
}
