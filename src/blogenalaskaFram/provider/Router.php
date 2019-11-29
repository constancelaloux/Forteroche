<?php

namespace blog\provider;
use blog\provider\Route;
use blog\exceptions\RouterException;

/**
 * Description of Router
 *
 * Register and match routes
 * @Pour commencer notre Router nous allons créer une première classe Router.
 *  Cette classe permettra d'ajouter des URLs à capturer, mais aussi le code à éxécuter
 */
class Router 
{
    private $response;
    private $request;// Contiendra l'URL sur laquelle on souhaite se rendre
    private $routes = [];// Contiendra la liste des routes
    private $namedRoutes = [];
    
    const NO_ROUTE = 1;

    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    
    //on teste une url en get
    //Nous allons commencer par la méthode get() qui prendra 2 paramètres
    //- L'URL à capturer
    //- La méthode à appeller lorsque cette URL est capturé. 
    //On va pour cela utiliser les fonctions anonymes qui ont fait leur apparition 
    //récemment.
    //Dans le cas ou j'ai des fonctions en get dans mes routes
    public function get($path, $callable, $name = null)
    {
        //J'ajoute à la fonction add de ma class router, le chemin de l'url, le nom du controller et sa fonction, 
        //ainsi que la variable globale en get
        return $this->add($path, $callable, $name, 'GET');
    }
    
    //on teste une url en post
    //Dans le cas ou j'ai des fonctions en post dans mes routes
    public function post($path, $callable, $name = null)
    {
        //J'ajoute à la fonction add de ma class router, le chemin de l'url, le nom du controller et sa fonction, 
        //ainsi que la variable globale en post
        return $this->add($path, $callable, $name, 'POST');
    }
    
    //On a un tableau qui sauvegarde les différentes routes
    //Je vais ajouter une nouvelle route
    private function add($path, $callable, $name, $method)
    {
        //je créé un objet route ou j'y met en paramétre le chemin de l'url et les données du controller
        $route = new Route($path, $callable);
        
        //Je stocke la liste de mes route dans mon objet route
        $this->routes[$method][] = $route;
        
        //Si le nom de mon controller est une chaine de caractéres et que la variable nom est null
        if(is_string($callable) && $name === null)
        {
            //Alors le nom du controller est stocké dans variable name
            $name = $callable;
        }
        //si j'ai une variable name
        if($name)
        {
            //je stocke dans $routes les routes qui ont un callable.
            $this->namedRoutes[$name] = $route;
        }
        
        return $route; // On retourne les routes pour "enchainer" les méthodes 
    }
    
    //Cette fonction va parcourir les différentes routes préalablement enregistrées 
    //et vérifier si la route correspond à l'URL qui est passé au contructeur, 
    //ceci gràce à la fonction match() de notre Route. Si aucune route ne correspond 
    //à l'URL ou à la méthode alors nous allonrs renvoyer une Exception qui pourra 
    //ensuite être capturée pour gérer un affiche correcte des erreurs.
    public function map($request)
    {
        //est ce que une des url correspond
        //montre si c'est en get ou post

        //Je fais appel à la fonction method de HTTP request qui va chercher si la methode du server est en get ou post
        $requestMethod = $request->method();

        //Si il n'y a pas de methode get ou post alors je lance une exception
        //if(!isset($this->routes[$_SERVER['REQUEST_METHOD']]))
        if(!isset($this->routes[$requestMethod]))
        {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        else
        {
        //Dans le cas ou j'ai une methode get ou post alors je parcours les routes du tableau
        //foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $routes)
            foreach($this->routes[$requestMethod] as $allroutes)
            {
                //Si dans le tableau des routes il y a une route qui correspond à l'url qui a ete tapé
                if($allroutes->match($this->request))
                {
                    //Alors je retourne une route et je fais appel à la fonction call
                    return $allroutes->call();
                }
            }
        }
        throw new RouterException('No matching routes');
        //return $this->response->redirect404();s
        //return $this->url('/test');
        //throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
    }
    
    //il prend en paramétres le nom de la route et les params dans un tableau
    public function url($name, $params=[])
    {
        //Est ce que l'url correspond et ensuite je l'execute
        if(!isset($this->namedRoutes[$name]))
        {
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
