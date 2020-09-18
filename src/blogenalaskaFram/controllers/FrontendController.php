<?php

namespace blog\controllers;

use blog\controllers\AbstractController;

/**
 * Description of FrontendController
 * @author constancelaloux
 */
class FrontendController extends AbstractController
{
    
    protected $comment;
    
    protected $postService;
    
    protected $commentService;
    
    public function __construct() 
    {
        parent::__construct();
        $this->postService = $this->container->get(\blog\service\PostService::class);
        $this->commentService = $this->container->get(\blog\service\CommentService::class);
        $this->comment = $this->container->get(\blog\entity\Comment::class);
    }
    
    /*
     * Function which render the home page
     */
    public function renderhomepage(): string
    {
        return $this->redirect("/articles:page=1");
    }
    
    public function renderPaginatedPosts(): ?array
    {
         return $this->postService->renderPaginatedPosts();
    }
    
    public function renderPaginatedComments(int $id): ?array
    {
        return $this->commentService->renderPaginatedComments($id);
    }
    
    /*
     * Function to the article page
     */
    public function renderPost()
    {
        //Test both methods in abstract controller
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
        
        /**
         * If i have a session, i show the form else i show a flash message 
         */
        if($this->userSession()->requireRole('client', 'admin'))
        {
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
        if(isset($commentform[1]) && $commentform[1] === true)
        {
            return $this->redirect("/article&id=$commentform[0]&page=1");
        }
        $title = 'Ecrire un commentaire';
        $this->getrender()->render('ArticleView', ['post' => $postFromId, 'lastsposts' => $lastsposts, 'form' => $commentform, 'previouslink' => $comment[2], 'nextlink' => $comment[1], /*'posts' => $posts,*/ 'comments' => $comment[0], 'title' => $title]);
    }
    
    /**
     * Redirect to main page with a success message after submit the email form
     * @return type
     */
    public function sendEmailToAuthor(): string
    {
        $this->addFlash()->success('Votre email a bien été envoyé!');
        return $this->redirect("/articles:page=1");
    }
              
    /*
     * Delete comment
     */
    public function deleteComment(): string
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
    
    public function unwantedComment(): object
    {
        (!is_null($_POST['number']) && ($_POST['id']));
        $number = $_POST['number'];
        $id = $_POST['id'];
        return $this->commentService->unwantedComment($number, $id);
    }
    
    /**
     * Render legal notices
     */
    public function renderLegalNotices(): void
    {
        $this->getrender()->render('LegalNotices');
    }
}
