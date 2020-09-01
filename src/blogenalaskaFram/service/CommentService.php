<?php

namespace blog\service;

use blog\Paginate;

use blog\config\Container;

use blog\database\Query;

use blog\exceptions\NotFoundHttpException;

use blog\form\CommentsForm;

use blog\database\EntityManager;

/**
 * Description of CommentService
 *
 * @author constancelaloux
 */
class CommentService
{
    protected $container;
    
    protected $comment;
    
    protected $commentEntityManager;
    
    protected $perPage;
    
    protected $previousLink;
    
    protected $nextLink;
    
    protected $paginateQueryComment;
    
    protected $request;
    
    protected $userSession;
    
    protected $addFlash;
    
    protected $response;
        
    public function __construct()
    {
        $services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        $this->comment = $this->container->get(\blog\entity\Comment::class);
        $this->commentEntityManager = new EntityManager($this->comment);
        $this->author = $this->container->get(\blog\entity\Author::class);
        $this->request = $this->container->get(\blog\HTTPRequest::class);
        $this->response = $this->container->get(\blog\HTTPResponse::class);
        $this->userSession = $this->container->get(\blog\user\UserSession::class);
        $this->addFlash = $this->container->get(\blog\error\FlashService::class);
    }
    /**
     * Show comments from the post id
     */
    public function renderPaginatedComments($id)
    {
        $this->perPage = 5;
        $this->comment->setIdpost($id);
        $this->comment->setStatus('Valider');
        $commentEntityManager = $this->commentEntityManager;
        $countItems = $commentEntityManager->exist(['idpost'=>$this->comment->idpost()]);
        $paginateQueryComment = new Paginate($this->comment, $this->perPage, $countItems);
        $offset = $paginateQueryComment->getItems();
        
        if($commentEntityManager->exist(['idpost'=>$this->comment->idpost()]))
        { 
            $comments = $query = (new Query($this->comment, $this->author))
                    ->from('comment', 'c')
                    ->select('c.id id','c.subject subject', 'a.image image', 'c.id_author id_author', 'a.username username','c.create_date create_date','c.update_date update_date', 'c.content content', 'c.countclicks countclicks')
                    ->join('author as a', 'c.id_author = a.id', 'inner')
                    ->where('id_post = :idpost')
                    ->setParams(array('idpost' => $this->comment->idpost()))
                    ->orderBy('create_date', 'ASC')
                    ->limit($this->perPage, $offset)
                    ->fetchAll();
            $this->previousLink = $paginateQueryComment->previouslink();
            $this->nextLink = $paginateQueryComment->nextlink();
            $array = [$comments, $this->nextLink, $this->previousLink];
            return $array;
        }
    }
         
    /**
     * I send into the database the reports and i increment each time when we click on the picture
     */
    public function unwantedComment($number, $id)
    {
        $model = $this->commentEntityManager;
        $comment = $model->findById($id);

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
    public function updateComment($idcomment)
    {
        return $this->processForm($idcomment);
    }
    
    /**
     * I show the form and i call the function to send the comments in database
     * @return type
     * @throws NotFoundHttpException
     */
    public function processForm(int $idComment = null)
    {
        if(!$idComment)
        {
            $model = $this->commentEntityManager;
            
        }
        else
        {
            /**
             * If there is a post id or get id
             */
            /**
             * I set the comment id in order to fill the getter and then i can search in database with the id to fill the object
             */
            $this->comment->setId($idComment);
            $model = $this->commentEntityManager;
            if(!($this->comment = $model->findById($this->comment->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $this->comment->setSubject($this->request->postData('subject'));
            $this->comment->setCommentContent($this->request->postData('commentContent'));
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

            if(!is_null($this->userSession->user()->id()))
            {
                $this->comment->setIdauthor($this->userSession->user()->id());
            }
            
            $this->comment->setIdpost($this->request->postData('idpost'));
            
        }

        /**
         * Create Form
         */
        $formBuilder = new CommentsForm($this->comment);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $model->persist($this->comment);
            $this->addFlash->success('Votre commentaire a bien été ajoutée !');
            $array = [$this->comment->idpost(), true];
            return $array;
        }
        return $form->createView();
    }
}