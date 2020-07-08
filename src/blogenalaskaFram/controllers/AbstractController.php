<?php

namespace blog\controllers;

use blog\config\Container;
use blog\form\Form;

/**
 * Description of AbstractController  
 * General controller to avoid to repeat few things into all controllers
 * it instanciate the page
 * @author constancelaloux
 */
abstract class AbstractController 
{
    protected $renderer;
    protected $httpResponse;
    protected $container;
    protected $flashService;
    protected $request;
    protected $form;   
    protected $flash;
    protected $userSession;
    protected $entityManager;

    
    /**
     * The constructor instanciate the class we can use in every controllers
     */
    public function __construct()
    {
        $this->setContainer();
        $this->request = $this->container->get(\blog\HTTPRequest::class);
        $this->renderer = $this->container->get(\blog\HTML\Render::class);
        $this->httpResponse = $this->container->get(\blog\HTTPResponse::class);
        $this->flashService = $this->container->get(\blog\error\FlashService::class);
        $this->userSession = $this->container->get(\blog\user\UserSession::class);
        //$this->form = $this->container->get(\blog\form::class, \blog\database\Model::class);
        //$this->entityManager = $this->container->get(\blog\database\EntityManager::class);
    }
    
    /**
    * Returns a container for injection of dependencies
    */
    public function setContainer()
    {
        $services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        return $this->container;
    }
    
    /**
    * Returns a RedirectResponse to the given URL.
    */
    protected function redirect(string $url)
    {
        return $this->httpResponse->redirectResponse($url);
    }
    
    /**
    * Returns an object Renderer to get the view we had as arg.
    */
    protected function getRender()
    {
        return $this->renderer;
    }
    
    /**
    * Returns an object FlashService.
    */
    protected function addFlash()
    {
        return $this->flashService;
    }
    
    protected function getFlash($type)
    {
        return $this->flashService->get($type);
    }
    
    /**
    * Returns an object Form.
    */
    protected function createForm()
    {
        return new Form();
        //return $this->form;
    }
    
    /**
     * Return a user session
     */
    protected function userSession()
    {
        return $this->userSession;
    }
    
    /**
     * Return entityManager
     */
    protected function getEntityManager($model)
    {
        return $this->entityManager = new \blog\database\EntityManager($model);
    }
}
