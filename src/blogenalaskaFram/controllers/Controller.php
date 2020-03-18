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
/**
 *Controller général qui évite les répétitions dans les controllers spécifiques.
 * Il instancie nottament page.
 */
class Controller 
{
    //protected $page = null;
    //protected $view = '';
    protected $renderer;
    protected $httpResponse;
    protected $container;
    
    //Le constructeur instancie page
    public function __construct()
    {
        $services   = include __DIR__.'/../config/Config.php';
        $configFile = new Container($services);
        //print_r($configFile);
        $this->container = $configFile;
        $this->renderer = $this->container->get(\blog\HTML\Renderer::class);
        $this->httpResponse = $this->container->get(HTTPResponse::class);
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
    * Returns a RedirectResponse to the given URL.
    */
    protected function redirect(string $url)
    {
        return $this->httpResponse->redirectResponse($url);
    }
    
    /**
    * Returns an object Renderer to get the view we had as arg.
    */
    public function getRender()
    {
        return $this->renderer;
        //return new Renderer();
    }
    
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
