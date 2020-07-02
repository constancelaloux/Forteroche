<?php

namespace blog\controllers;

use blog\HTTPResponse;
use blog\config\Container;
use blog\error\FlashService;
use blog\form\Form;
use blog\user\UserSession;

/**
 * General controller to avoid to repeat few things into all controllers
 * it instanciate the page
 */
abstract class AbstractController 
{
    protected $renderer;
    protected $httpResponse;
    protected $container;
    protected $flashService;
    public $request;
    public $form;
    
    public $flash;
    public $userSession;

    
    /**
     * Le constructeur instancie page
     */
    public function __construct()
    {
        $this->request = new \blog\HTTPRequest();
        $this->setContainer();
        $this->renderer = $this->container->get(\blog\HTML\Render::class);
        $this->httpResponse = $this->container->get(HTTPResponse::class);
        $this->flashService = new FlashService();
        $this->userSession = new UserSession();
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
    }
    
    /**
     * return a user session
     */
    protected function userSession()
    {
        return $this->userSession;
    }
}
