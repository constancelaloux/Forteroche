<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace blogenalaska\src\blogenalaskaFram;

class Router
    {
        /* 
        * var string
        */
        private $viewPath;
        
        /* 
         * var Altorouter
        */
        private $router;
        
        public function __construct(string $viewPath)
            {
                $this->viewPath = $viewPath;
                //print_r($this);
                $this->router = new \AltoRouter();
                $this->router->setBasePath('/blogenalaska/Public');
                //$this->router->map($viewPath, $route, $target);
                
            }
       
        //self: le retour ca sera le classe
        public function get(string $url, string $view, string $name = null):self
            {
                $this->router->map('GET', $url, $view, $name);
                return $this;
            }
            
        public function post(string $url, string $view, string $name = null):self
            {
                $this->router->map('POST', $url, $view, $name);
                return $this;   
            }
        
        public function run():self
            {
                //Est ce que l'url qui est tapé correspond à une de ces routes enregistrés
                //ca retourne un tableau associatif

                $match = $this->router->match();
                if (is_array($match)) 
                    {
                        $view = $match['target'];
                        ob_start();
                        //print_r($this->viewPath.'/'.$view.'.php');
                        require $this->viewPath.'/'.$view.'.php';
                        $content = ob_get_clean();
                        require $this->viewPath.DIRECTORY_SEPARATOR.'template/Layout.php';

                        return $this;
                    }
                else
                    {
                        echo"HTTP/1.0 404 Not Found";
                    }

                /*if (is_array($match)) 
                    {
                        if(is_callable($match['target']))
                            {
                                call_user_func_array($match['target'], $match['params']);
                            //$match['target']();
                            }
                        else 
                            {
                                $params =$match['params'];
                                ob_start();
                                require __DIR__ ."/../views/{$match['target']}.php";
                                $content = ob_get_clean();
                            }
                        require  __DIR__ .'/../Template/Layout.php';
                    }
                else {
                    echo"HTTP/1.0 404 Not Found";
                }  */
            }
    }
