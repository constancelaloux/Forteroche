<?php

namespace blog\service;

use blog\Paginate;

use blog\config\Container;

use blog\database\EntityManager;

use blog\database\Query;

use blog\exceptions\NotFoundHttpException;

use blog\form\CommentsForm;

use blog\HTTPRequest;

use blog\entity\Author;

use blog\user\UserSession;

use blog\error\FlashService;

use blog\HTTPResponse;

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
    
    protected $perPage; // = 5;
    
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
        $this->author = new Author();
        $this->commentEntityManager = new EntityManager($this->comment);
        //$this->paginateQueryComment = new Paginate($this->comment, $this->perPage);
        $this->request = new HTTPRequest();
        $this->response = new HTTPResponse();
        $this->userSession = new UserSession();
        $this->addFlash = new FlashService();
    }
    /**
     * Show comments from the post id
     */
    public function renderPaginatedComments($id)
    {
        $comment = new \blog\entity\Comment();
        $author = new Author();
        $this->perPage = 5;
        $paginateQueryComment = new Paginate($comment, $this->perPage);
        $offset = $paginateQueryComment->getItems();
        
        $comment->setIdpost($id);
        $comment->setStatus('Valider');
        $commentEntityManager = new EntityManager($comment);
        
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
    public function createComment()//$idcomment = null)
    {
        return $this->processForm();//$idcomment = null);
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
        //print_r($idComment);
        if(!$idComment)
        {
            //$model = $this->commentEntityManager;
            $model = new EntityManager($this->comment);
            
        }
        else
        {
            /**
             * If there is a post id or get id
             */
            /**
             * Je set l'id de commentaire pour ensuite l'avoir en getter et pouvoir
             * rechercher en base de données en fonction de l'id et ainsi remplir l'objet
             */
            $this->comment->setId($idComment);
            //$model = $this->commentEntityManager;
            $model = new EntityManager($this->comment);
            if(!($this->comment = $model->findById($this->comment->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
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

            if(!is_null($this->userSession->user()->id()))
            {
                $this->comment->setIdclient($this->userSession->user()->id());
            }
            
            $this->comment->setIdpost($this->request->postData('idpost'));
            
        }

        // Création du formulaire
        $formBuilder = new CommentsForm($this->comment);
        $form = $formBuilder->buildform($formBuilder->form());
        
        
        if ($this->request->method() == 'POST' && $form->isValid())
                //&& $this->comment->subject() != ""
                //&& $this->comment->content() != "")
        {
            //$model = new EntityManager($this->comment);
            $model->persist($this->comment);
            $this->addFlash->success('Votre commentaire a bien été ajoutée !');
            
            return true;
            //return $this->response->redirectResponse('/');    
        }
        
        /*echo '<pre>';
        print_r($form->createView());
        echo '</pre>';
        die("FIN"); */
        return $form->createView();
        //return $form->createView();
    }
}