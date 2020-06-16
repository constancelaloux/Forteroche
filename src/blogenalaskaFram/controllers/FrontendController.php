<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\entity\Comment;
use blog\database\EntityManager;
use blog\entity\Post;
use blog\database\Query;
use blog\Paginate;
/**
 * Description of BlogController
 *
 * @author constancelaloux
 */
class FrontendController extends AbstractController
{
    private $perPage;
    
    public $post;
    
    public $comment;
    
    public $paginateQuery;
    
    public $previousLink;
    
    public $nextLink;
    
    public function __construct() 
    {
        parent::__construct();
        $this->post = new Post();
        $this->comment = new Comment();
    }
    
    /*
     * Fonction qui permet de rendre la page d'accueil
     */
    public function renderhomepage()
    {
        return $this->redirect("/articles:page=1");
    }
    
    /**
     * pagination et rendre articles
     */
    public function renderPaginatedPosts()
    {
        $lastsposts = $this->getLastsPosts();
        $model = new EntityManager($this->post);
        $perPage = 9;
        $paginatedQuery = new \blog\Paginate($this->post, $perPage);
        $offset = $paginatedQuery->getItems();
        $posts = $model->findBy($filters = NULL, [$orderBy = 'create_date'], $limit = $perPage, $offset = $offset);
        $previouslink = $paginatedQuery->previouslink();
        $nextlink = $paginatedQuery->nextlink();
        $this->getrender()->render('FrontendhomeView',['posts' => $posts, 'previouslink' => $previouslink, 'nextlink' => $nextlink, 'lastsposts' => $lastsposts]);
    }
    
    /*
     * Fonction qui permet de rendre la page de l'article
     */
    public function renderPost()
    {
        //J'affiche les commentaires
        $comments = $this->renderPaginatedComments($_GET['id']);
        
        //Je vais chercher les derniers articles
        $lastsposts = $this->getLastsPosts();
        
        //J'affiche le formulaire pour écrire les commentaires
        $commentform = $this->createComment();
        
        //J'affiche l'article en fonction de l'id
        $postFromId = $this->getPost($_GET['id']);
        
        //J'affiche la page avec tous les composants
        $this->getrender()->render('ArticleView', ['post' => $postFromId, 'lastsposts' => $lastsposts, 'form' => $commentform, 'previouslink' => $this->previousLink, 'nextlink' => $this->nextLink, /*'posts' => $posts,*/ 'comments' => $comments]);
    }
    
    /**
     * Je vais chercher les 3 derniers articles
     */
    public function getLastsPosts()
    {
        $model = new EntityManager($this->post);
        $lastsposts = $model->findBy($filters = NULL, [$orderBy = 'create_date'], $limit = 3, $offset = 0);
        return $lastsposts;
        //$getLastArticle = $this->_db->prepare("SELECT * FROM articles  WHERE status = :status ORDER BY ID DESC LIMIT 0, 2");
    }
    
    /**
     * J'affiche l'article en fonction de l'id et sa pagination
     * @param type $id
     * @return type
     */
    public function getPost($id)
    {
        $model = new EntityManager($this->post);
        return $postFromId = $model->findById($id);
    }
    
    /**
     * On affiche les commentaires liés à l'article
     */
    public function renderPaginatedComments($id)
    {
        $query = NULL;
        $perPage = 5;
        $this->paginateQuery = new Paginate($this->comment, $perPage);
        $offset = $this->paginateQuery->getItems();
        
        $this->comment->setIdpost($id);
        $this->comment->setStatus('Valider');
        $model = new EntityManager($this->comment);
        
        if($model->exist(['idpost'=>$this->comment->idpost()]))
        { 
            $comments = $query = (new Query($this->comment))
                    ->from('comments', 'c')
                    ->select('c.id id','c.subject subject', 'a.image image', 'c.id_client id_client', 'a.username username','c.create_date create_date','c.update_date update_date', 'c.content content', 'c.countclicks countclicks')
                    ->join('author as a', 'c.id_client = a.id', 'inner')
                    //->join('$author->getTable() as a', 'c.id_client = a.id', 'inner')
                    ->where('id_post = :idpost')
                    ->setParam('idpost', $this->comment->idpost())
                    ->orderBy('create_date', 'ASC')
                    ->limit($perPage, $offset)
                    ->fetchAll();
            $this->previousLink = $this->paginateQuery->previouslink();
            $this->nextLink = $this->paginateQuery->nextlink();
            return $comments;
        }
    }
    
    /**
     * J'envoi en base de données les signelements de commentaires et j'incrémente à chaque fois que l'on clique sur le bouton
     */
    public function unwantedComment()
    {
        $number = $_POST['number'];
        $model = new EntityManager($this->comment);
        //$this->comment = $model->findById($_POST['id']);
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
     * Fonction qui me permet de créer un commentaire
     */
    public function createComment()
    {
        return $this->processForm();
    }
    
    /*
     * Fonction qui me permet de modifier un commentaire
     */
    public function updateComment()
    {
        if($this->userSession()->requireRole('client', 'admin'))
        {
            //print_r($_GET['idcomment']);
            //print_r($_POST);
            //die("meurs ici");
            $this->processForm();
        }
        else
        {
            $this->addFlash()->error('Vous ne pouvez pas supprimer ce commentaire!');
            $id = $this->request->postData('idpost');
            return $this->redirect("/article&id=$id");
        }
    }
    
    /**
     * J'affiche le formulaire et j'appelle la fonction qui envoi les commentaires en base de données
     * @return type
     * @throws NotFoundHttpException
     */
    public function processForm()
    { 
        //print_r($_GET['idcomment']);
        //Si il n'y a pas d'id en post ni en get, je créé un nouveau commentaire
        if(is_null($this->request->getData('idcomment')) && is_null($this->request->postData('idcomment')))
        {
            //$comment = new Comment();
            $model = new EntityManager($this->comment);
        }
        else
        {
            //Si il y a un id en post ou en get
            //$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
            $idComment = $this->request->postData('idcomment') ? $this->request->postData('idcomment') : $this->request->getData('idcomment');
           /* $this->comment(
                [
                    'id' =>  $id,
                ]);*/;
            $this->comment->setId($idComment);
            $model = new EntityManager($this->comment);
            
            //Dans le cas ou il n'y pas l'id en base de données
            // Récupère l'objet en fonction de l'@Id (généralement appelé $id)
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
            
            if($idComment)
            {
                $this->comment->setUpdatedate(date("Y-m-d H:i:s"));
            }
            else
            {
                $this->comment->setCreatedate(date("Y-m-d H:i:s"));
            }
            
            $this->comment->setCountclicks(NULL);
            //$this->comment->setIdclient($_SESSION['authorId']);
            if(!is_null($this->userSession()->user()->id()))
            {
                $this->comment->setIdclient($this->userSession()->user()->id());
            }
            
            $this->comment->setIdpost($this->request->postData('idpost'));
        }
        
        $formBuilder = new \blog\form\CommentsForm($this->comment);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {  
            $model = new EntityManager($this->comment);
            $model->persist($this->comment);
            $this->addFlash()->success('Votre commentaire a bien été ajoutée !');
            $id = $this->request->postData('idpost');
            
            if(!is_null($this->request->getData('idcomment')))
            {   
                $id = $this->request->getData('id');
                return $this->redirect("/article&id=$id&idcomment=$idComment");
            }
            else
            {
                return $this->redirect("/article&id=$id");
            }
        }
        
        if($this->userSession()->requireRole('client', 'admin'))
        {
            //$title = "Créer un commentaire";
            //$this->getrender()->render('',['form' => $form->createView()]);
            return $form->createView();
            //$this->getrender()->render('ArticleView',['title' => $title, 'form' => $form->createView()]);
            
        }
        else 
        {
            return $this->addFlash()->error('Veuillez vous inscrire pour ajouter un commentaire!');
            //return $this->redirect("/article&id=$id");
        }
    }
    
    /*
     * Fonction qui me permet de supprimer un commentaire
     */
    public function deleteComment()
    {
        if ($this->request->method() == 'POST')
        {
            if($this->userSession()->requireRole('client', 'admin'))
            {
                /*$this->comment(
                [
                    'id' =>  $this->request->postData('id'),
                ]);*/
                $this->comment->setId($this->request->postData('id'));
                $model = new EntityManager($this->comment);
                $model->remove($this->comment);
            }
            else
            {
                $this->addFlash()->error('Vous ne pouvez pas supprimer ce commentaire!');
                $postid = $this->request->postData('idpost');
                return $this->redirect("/article&id=$postid");
            }
        }  
    }  
}   
            /*("SELECT a.subject subject, "
            . "c.id id, c.create_date create_date, c.update_date update_date, c.content content, c.countclicks countclicks "
            . "FROM articles a "
            . "INNER JOIN comments c ON a.id = c.id_From_Article "
            . "WHERE c.status = :status order by countclicks DESC");*/
                    //print_r($comments);
                //$commen = [];
                /*foreach ($comments as $comment)
                {
                    //$arrayComments = NULL;
                    print_r($comment);
                    $author = new \blog\entity\Author();
                    $arrayComments = $author->setId($comment->id);
                    $arrayComments = $author->setImage($comment->image);
                    $arrayComments = $author->setUsername($comment->username);
                    
                    $arrayComments = $this->comment->setSubject($comment->subject);
                    $arrayComments = $this->comment->setContent($comment->content);
                    $arrayComments = $this->comment->setCreatedate($comment->create_date);
                    //print_r($comment);
                    //$comment->id;
                    //print_r($comment->id);
                    //die('meurs');
                    //print_r($listOfComments);
                }*/
            //$comments->closeCursor();
            //SELECT * FROM comments c INNER JOIN author AS a ON c.id_client = a.id WHERE id_post = 102
            //=> $this->comment->idpost()
            //$comments = $query->fetchAll();
            //$test = (new \blog\database\QueryBuilder())->from($this->comment)->select('*')->join('author', $condition);
            //$comments = $model->findBy(['idpost' => $this->comment->idpost(), 'status' => $this->comment->status()], [$orderBy = 'create_date'], $limit = $perPage, $offset = $offset);
            //return $comments;




/*if ($this->request->method() == 'POST')
        {
            print_r($_POST);
            print_r($this->request->postData('idpost'));
            print_r($this->request->postData('subject'));
            print_r($this->request->postData('content'));
            print_r($this->request->postData('validate'));
            //die("meurs");
            //Création de l'entité author
            $author = new \blog\entity\Author(
            [
                //'id' => $_SESSION['authorId']
                'id' => 1
            ]);
            // Création de l'entité Post
            $post = new Post(
            [
                'id' => $this->request->postData('idpost')
            ]);
            
            $comment = new Comment(
            [
                'subject' =>  $this->request->postData('subject'),
                'content' =>  $this->request->postData('content'),
                //'image' =>  $this->request->postData('image'),
                'status' =>  $this->request->postData('validate'),
                'create_date' => date("Y-m-d H:i:s"),
                'update_date' => null,
                'id_client' => $author,
                'id_post' => $post,
                'countclicks' => NULL
            ]);
                // On lie l'image à l'article
                //$article->setImage($image);
        }
        else
        {
            $comment = new Comment();
        }*/



        //$link = '/articles';
        //$posts = $paginatedQuery->getItems();
        //$previouslink = $paginatedQuery->previouslink($link);
        //$nextlink = $paginatedQuery->nextlink($link);


            //$post = new Post();
            //$post->setId($this->request->postData('idpost'));
            //print_r($postid);
            /*$author = new \blog\entity\Author();
            $auth = $author->setId(1);
            print_r($auth);*/
