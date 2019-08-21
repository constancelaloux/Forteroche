<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blogenalaska\Lib\BlogenalaskaFram;
//require(__DIR__ . '/../Lib/BlogenalaskaFram/vendor/autoload.php');
use blogenalaska\Lib\BlogenalaskaFram\HTTPRequest;
use blogenalaska\Lib\BlogenalaskaFram\HTTPResponse;
use blogenalaska\Lib\BlogenalaskaFram\Router;
//print_r('je passe dans application aussi');
/**
 * Description of Application
 *
 * @author constancelaloux
 */
abstract class Application 
    {
        //La requéte du client
        protected $httpRequest;
        //La réponse envoyé au client
        protected $httpResponse;
        //Le nom de l'application.chaque application (qui héritera donc de cette classe) 
        //sera chargée de spécifier son nom en initialisant cet attribut (par exemple, 
        //l'application frontend assignera la valeur Frontend à cet attribut).
        protected $name;
        
        //J'implémente le constructeur
        //Le constructeur se charge uniquement d'instancier 
        //les classes HTTPRequest et HTTPResponse. 
        //Cela évite d'avoir à les instancier plusieurs fois et ils sont appellé au début
        //Quant aux autres méthodes, ce sont des accesseurs, 
        //nous avons donc vite fait le tour.
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
        //Nous venons de construire notre routeur qui donne à 
        //l'application le contrôleur associé. Afin de suivre la 
        //logique du déroulement de l'application, construisons 
        //maintenant notre back controller de base.
        public function getController()
            {
                //print_r('je passe dans get controller aussi');
                //Je créé un objet de router pour pouvoir accéder à ses fonctions par la suite
                $router = new Router;

                //Ensuite je vais récupérer la route dans le fichier xml
                //On va dans le fichier xml de l'application indiqué
                $xml = new \DOMDocument;

                $xml->load(__DIR__.'/../../../blogenalaska/'.$this->name.'/Config/routes.xml');

                $routes = $xml->getElementsByTagName('route');

                // On parcourt les routes du fichier XML.
                //J'ai récupéré la route et je voudrais lire le tableau
                //print_r("je suis la");
                foreach ($routes as $route)
                    {
                        //On créé un tableau vide
                        $vars = [];

                        // On regarde si des variables sont présentes dans l'URL.
                        if ($route->hasAttribute('vars'))
                            {
                                $vars = explode(',', $route->getAttribute('vars'));
                            }

                        // On ajoute la route au routeur.
                        //Mes setters ont des données provenant de la route. 
                        //J'ai donc un tableau avec les données de ma route
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
                $controllerClass = 'blogenalaska\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
                print_r($controllerClass);
                return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
            }
            
        abstract public function run();
        /*public function run()
        {
            echo 'Bonjour je suis dans la  class application et je fonctionne grace à l\'autoloader';
        }*/
        
        //Retourne la requéte du client
        public function httpRequest()
            {
              return $this->httpRequest;
            }
        
        //Retourne la réponse du client
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
