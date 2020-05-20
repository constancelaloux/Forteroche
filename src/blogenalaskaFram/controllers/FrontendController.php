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
        /*$this->perPage = (int)12;
        print_r($this->perPage);
        //$currentPage = $_GET['page'];
        //print_r($currentPage);
                die('meurs');
        //$currentPage = URL::getPositiveInt('page', 1);
        $post = new Post();
        $model = new EntityManager($post);
        $count = $model->exist();
        print_r($count);
        $pages = ceil($count / $this->perPage);
        if($currentPage > $pages)
        {
            throw new Exception("Cette page n'existe pas");
        }
        $offset = $this->perPage * ($currentPage - 1);
        $posts = $model->findBy($this->perPage, $offset);
        die("meurs");*/
        // Retrouver tous les articles
        //$post = new Post();
        //$model = new EntityManager($post);
        //$posts = $model->findAll();
        //$this->getrender()->render('FrontendhomeView',['posts' => $posts]);
        $this->getrender()->render('FrontendhomeView');
    }
    
    /*
     * Fonction qui permet de rendre la page de l'article
     */
    public function renderArticle()
    {
        $this->getrender()->render('ArticleView');
    }
    
    /**
     * pagination et rendre articles
     */
    public function renderPaginatedArticles()
    {
        $post = new Post();
        $perPage = 9;
        $paginatedQuery = new \blog\Paginate($post, $perPage);
        //print_r($posts);
        $link = '/articles';
        $posts = $paginatedQuery->getItems();
        $previouslink = $paginatedQuery->previouslink($link);
        $nextlink = $paginatedQuery->nextlink($link);
        //print_r($previouslink);

        // Retrouver tous les articles
        //$posts = $model->findAll();
        $this->getrender()->render('FrontendhomeView',['posts' => $posts, 'previouslink' => $previouslink, 'nextlink' => $nextlink]);
    }
    
    /*
     * Fonction qui me permet de créer un commentaire
     */
    public function createComment()
    {
        if ($this->request->method() == 'POST')
        {
            $comment = new Comment(
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
            $comment = new Comment();
        }
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {  
            $model = new EntityManager($comment);
            $model->persist($comment);
            $this->addFlash()->success('La news a bien été ajoutée !');
            return $this->redirect('/backoffice');
        }
        
        if($this->userSession()->requireRole('client', 'admin'))
        {
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
            
        }
        else 
        {
            $this->addFlash()->error('Vous n\avez pas acces à cette page!');
            return $this->redirect('/connectform');
        }
        
    }
    
    /*
     * Fonction qui me permet de modifier un commentaire
     */
    public function updateComment()
    {
        
    }
    
    /*
     * Fonction qui me permet de supprimer un commentaire
     */
    public function deleteComment()
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
}
