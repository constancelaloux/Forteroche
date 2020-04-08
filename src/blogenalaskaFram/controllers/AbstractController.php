<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\controllers;

use blog\HTTPResponse;
//use blog\Page;
use blog\HTML\Renderer;
use blog\config\Container;
use blog\config\ContainerInterface;
use blog\session\FlashService;
use blog\session\PHPSession;
use blog\form\Form;
/**
 *Controller général qui évite les répétitions dans les controllers spécifiques.
 * Il instancie nottament page.
 */
abstract class AbstractController 
{
    //protected $page = null;
    //protected $view = '';
    protected $renderer;
    protected $httpResponse;
    protected $container;
    protected $flashService;
    //private $session;
    public $request;
    public $form;
    
    public $flash;

    
    //Le constructeur instancie page
    public function __construct()
    {
        $this->request = new \blog\HTTPRequest();
        $this->form = new Form();
        $this->setContainer();
        $this->renderer = $this->container->get(\blog\HTML\Renderer::class);
        $this->httpResponse = $this->container->get(HTTPResponse::class);
        $this->flashService = new FlashService();
        //$this->form = new Form3;
        //$this->renderer = new Renderer();     
        //$this->page = new Page();
        //$this->setView($view);
        //$this->renderer = new Renderer();
        //$this->renderer->addPath('blog',__DIR__.'/../views');
        //$this->renderer = new Renderer();
        //$this->renderer->addPath(__DIR__.'/../views');
        //print_r($this->renderer->addPath('blog', __DIR__.'/views'));
    }
    
    /**
    * Returns a container for injection of dependencies
    */
    public function setContainer()
    {
        $services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        //print_r($configFile);
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
        //return new Renderer();
    }
    
    /**
    * Returns an object FlashService.
    */
    protected function addFlash()
    {
        return $this->flashService;
        /**/
        //return $this->flashService = $this->container->get(FlashService::class);
            //return $this->container->get(blog\session\FlashService::class);
        /*}*/
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
    
    /*protected function getParams($datas)
    {
        $request = new \blog\HTTPRequest();
        return $request->postData($datas);
        /*if (!is_string($var) || is_numeric($var) || empty($var))
        {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
        }

        $this->vars[$var] = $value;
    }*/
 
    
    /*public function getPage()
    {
        return $this->renderer->render('@blog/Blog');
    }*/
    //D'obtenir la page associée au contrôleur.
    /*public function page()
        {
        //print_r($this->page());
        //exit("je sors");
            return $this->page;
        }*/
        
    //De modifier la vue associée au contrôleur.
    /*public function setView($view)
    {
        if (!is_string($view) || empty($view))
        {
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
        }

        $this->view = $view;
        $this->page->setContentFile(__DIR__.'/views/'.$this->view.'.php');
        //$this->page->setContentFile(__DIR__.'/../../Views/'.$this->view.'.php');
        //print_r(__DIR__.'/Views/'.$this->view.'.php');
    }*/
}
