<?php

namespace blog\service;

use blog\Paginate;

use blog\database\EntityManager;

use blog\HTML\Render;

use blog\config\Container;

use blog\entity\Post;

/**
 * Description of PostService
 *
 * @author constancelaloux
 */
class PostService 
{
    protected $container;
    
    protected $post;
    
    protected $postEntityManager;
    
    protected $perPage;
    
    protected $paginatedQueryPost;
    
    protected $previouslink;
    
    protected $nextlink;
    
    protected $render;
    
    public function __construct()
    {
        /*$services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);*/
        //$this->post = $this->container->get(\blog\entity\Post::class);
        //$this->postEntityManager = new EntityManager($this->post);
        //$this->paginatedQueryPost = new Paginate($this->post, $this->perPage);
        $this->render = new Render();
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
        //$model = $this->getEntityManager($this->post);
        $post = new Post();
        $model = new EntityManager($post);
        $this->perPage = 9;
        //$this->paginatedQueryPost = new Paginate($this->post, $this->perPage);
        $countItems = $model->exist();
        $paginatedQueryPost = new Paginate($post, $this->perPage, $countItems);
        $offset = $paginatedQueryPost->getItems();
        $posts = $model->findBy($filters = NULL, [$orderBy = 'create_date'], $limit = $this->perPage, $offset = $offset);
        $this->previouslink = $paginatedQueryPost->previouslink();
        $this->nextlink = $paginatedQueryPost->nextlink();
        $this->render->render('FrontendhomeView',['posts' => $posts, 'previouslink' => $this->previouslink, 'nextlink' => $this->nextlink, 'lastsposts' => $lastsposts]);
    }
        
    /**
     * I will get the lasts three posts
     */
    public function getLastsPosts()
    {
        $post = new Post();
        $model = new EntityManager($post);
        //$model = $this->getEntityManager($this->post);
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
        $post = new Post();
        $model = new EntityManager($post);
        //$model = $this->getEntityManager($this->post);
        return $postFromId = $model->findById($id);
    }
}
