<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\entity\Comment;
use blog\database\EntityManager;
use blog\entity\Post;
use Exception;
/**
 * Description of BlogController
 *
 * @author constancelaloux
 */
class FrontendController extends AbstractController
{
    private $perPage;
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
        $post = new Post();
        $perPage = 9;
        $paginatedQuery = new \blog\Paginate($post, $perPage);
        $posts = $paginatedQuery->getItems();
        $previouslink = $paginatedQuery->previouslink();
        $nextlink = $paginatedQuery->nextlink();
        $this->getrender()->render('FrontendhomeView',['posts' => $posts, 'previouslink' => $previouslink, 'nextlink' => $nextlink, 'lastsposts' => $lastsposts]);
    }
    
    /*
     * Fonction qui permet de rendre la page de l'article
     */
    public function renderPost()
    {
        //Je vais chercher les derniers articles
        $lastsposts = $this->getLastsPosts();
        
        //J'affiche les commentaires
        $comments = $this->renderPaginatedComments($_GET['id']);
        
        //J'affiche le formulaire pour écrire les commentaires
        $commentform = $this->createComment();
        
        //J'affiche l'article en fonction de l'id
        $post = new Post();
        $model = new EntityManager($post);
        $postfromid = $model->findById($_GET['id']);
        
        //j'affiche la pagination de l'article
        $perPage = 1;
        $paginatedQuery = new \blog\Paginate($post, $perPage);
        $previouslink = $paginatedQuery->previouslink();
        $nextlink = $paginatedQuery->nextlink();
        $posts = $paginatedQuery->getItems();
        
        //J'affiche la page avec tous les composants
        $this->getrender()->render('ArticleView', ['post' => $postfromid, 'lastsposts' => $lastsposts, 'form' => $commentform, 'previouslink' => $previouslink, 'nextlink' => $nextlink, 'posts' => $posts, 'comments' => $comments]);
    }
    
    /**
     * Je vais chercher les 3 derniers articles
     */
    public function getLastsPosts()
    {
        $post = new Post();
        $model = new EntityManager($post);
        $lastsposts = $model->findBy($filters = NULL, [$orderBy = 'create_date'], $limit = 3, $offset = 0);
        return $lastsposts;
        //$getLastArticle = $this->_db->prepare("SELECT * FROM articles  WHERE status = :status ORDER BY ID DESC LIMIT 0, 2");
    }
    
    /**
     * On affiche les commentaires liés à l'article
     */
    public function renderPaginatedComments($id)
    {
        $comment = new Comment();
        $perPage = 5;
        $paginatedQuery = new \blog\Paginate($comment, $perPage);
        $comments = $paginatedQuery->getItems();
        return $comments;
    }
    
    /*
     * Fonction qui me permet de créer un commentaire
     */
    public function createComment()
    {
        $this->processForm();
    }
    
    /*
     * Fonction qui me permet de modifier un commentaire
     */
    public function updateComment()
    {
        if($this->userSession()->requireRole('client', 'admin'))
        {
            $this->processForm();
        }
        else
        {
            $this->addFlash()->error('Vous ne pouvez pas supprimer ce commentaire!');
            $id = $this->request->postData('idpost');
            return $this->redirect("/article&id=$id");
        }
    }
    
    public function processForm()
    { 
        //Si il n'y a pas d'id en post ni en get, je créé un nouvel article
        if(is_null($this->request->getData('id')) && is_null($this->request->postData('id')))
        {
            $comment = new Comment();
            $model = new EntityManager($comment);
        }
        else
        {
            //Si il y a un id en post ou en get
            //$id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];
            $id = $this->request->postData('id') ? $this->request->postData('id') : $this->request->getData('id');
            $comment = new Comment(
                [
                    'id' =>  $id,
                ]);
            $model = new EntityManager($comment);
            
            //Dans le cas ou il n'y pas l'id en base de données
            // Récupère l'objet en fonction de l'@Id (généralement appelé $id)
            if(!($comment = $model->findById($comment->id())))
            {
                throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
            }
        }
 
        if($this->request->method() == 'POST')
        {
            $comment->setSubject($this->request->postData('subject'));
            $comment->setContent($this->request->postData('content'));
            //$post->setImage($this->request->postData('image'));
            $comment->setStatus($this->request->postData('validate'));
            $comment->setCreatedate(date("Y-m-d H:i:s"));
            $comment->setUpdatedate(date("Y-m-d H:i:s"));
            $comment->setCountclicks(NULL);
            $comment->setIdclient($_SESSION['authorId']);
            $comment->setIdpost($this->request->postData('idpost'));
        }
        
        $formBuilder = new \blog\form\CommentsForm($comment);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {  
            $model = new EntityManager($comment);
            $model->persist($comment);
            $this->addFlash()->success('Votre commentairea bien été ajoutée !');
            $id = $this->request->postData('idpost');
            return $this->redirect("/article&id=$id");
        }
        
        if($this->userSession()->requireRole('client', 'admin'))
        {
        //$title = "Créer un commentaire";
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
                $comment = new Comment(
                [
                    'id' =>  $this->request->postData('id'),
                ]);
                $model = new EntityManager($comment);
                $model->remove($comment);
            }
            else
            {
                $this->addFlash()->error('Vous ne pouvez pas supprimer ce commentaire!');
                $id = $this->request->postData('idpost');
                return $this->redirect("/article&id=$id");
            }
        }  
    }  
}         /*if ($this->request->method() == 'POST')
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
