<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Forteroche\blogenalaska\Lib\BlogenalaskaFram;

/**
 * Description of Application
 *
 * @author constancelaloux
 */

//Le constructeur se charge uniquement d'instancier les classes HTTPRequest et HTTPResponse. 
//Quant aux autres méthodes, ce sont des accesseurs, nous avons donc vite fait le tour.
abstract class Application 
    {
        //put your code here
        protected $httpRequest;
        protected $httpResponse;
        protected $name;

        public function __construct()
            {
              $this->httpRequest = new HTTPRequest($this);
              $this->httpResponse = new HTTPResponse($this);
              $this->name = '';
            }
        
        //Je vais récupérer le controlleur qui correspond à la route
        //Pour cela, nous allons implémenter une méthode 
        //dans notre classe Application qui sera chargée 
        //de nous donner le contrôleur correspondant à 
        //l'URL. Pour cela, cette méthode va parcourir 
        //le fichier XML pour ajouter les routes au 
        //routeur. Ensuite, elle va récupérer la route 
        //correspondante à l'URL (si une exception a été 
        //levée, on lèvera une erreur 404). Enfin, la 
        //méthode instanciera le contrôleur correspondant 
        //à la route et le renverra
        public function getController()
            {
                $router = new Router;

                $xml = new \DOMDocument;
                $xml->load(__DIR__.'/../../App/'.$this->name.'/Config/routes.xml');

                $routes = $xml->getElementsByTagName('route');

                // On parcourt les routes du fichier XML.
                foreach ($routes as $route)
                    {
                        $vars = [];

                        // On regarde si des variables sont présentes dans l'URL.
                        if ($route->hasAttribute('vars'))
                            {
                                $vars = explode(',', $route->getAttribute('vars'));
                            }

                        // On ajoute la route au routeur.
                        $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
                    }

                try
                    {
                        // On récupère la route correspondante à l'URL.
                        $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
                    }
                catch (\RuntimeException $e)
                    {
                        if ($e->getCode() == Router::NO_ROUTE)
                            {
                                // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
                                $this->httpResponse->redirect404();
                            }
                    }

                // On ajoute les variables de l'URL au tableau $_GET.
                $_GET = array_merge($_GET, $matchedRoute->vars());

                // On instancie le contrôleur.
                $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
                return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
            }
            
        abstract public function run();

        public function httpRequest()
            {
              return $this->httpRequest;
            }

        public function httpResponse()
            {
              return $this->httpResponse;
            }

        //Dans le constructeur, vous voyez qu'on assigne une valeur nulle à l'attribut name.
        // En fait, chaque application (qui héritera donc de cette classe) sera chargée de spécifier 
        // son nom en initialisant cet attribut (par exemple, l'application frontend assignera la valeur 
        // Frontend à cet attribut).
        public function name()
            {
              return $this->name;
            }
    }
