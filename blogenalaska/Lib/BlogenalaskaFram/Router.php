<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require(__DIR__ . '/../Lib/BlogenalaskaFram/vendor/autoload.php');
namespace blogenalaska\Lib\BlogenalaskaFram;

use blogenalaska\Lib\BlogenalaskaFram\Route;
/**
 * Description of Router
 *
 * @author constancelaloux
 */
//Je vérifie si la route correspond à l'url et si elle posséde des
//variables
class Router 
    {
        //Les routes sont stockés dans un tableau
        protected $routes = [];
        const NO_ROUTE = 1;
        
        //J'ajoute une route dans mon tableau aprés avoir hydraté les setters
        public function addRoute(Route $route)
            {
                if (!in_array($route, $this->routes))
                    {
                      $this->routes[] = $route;
                      //print_r($this);
                    }
            }
        
        //Je récupére une route
        public function getRoute($url)
            {
                foreach ($this->routes as $route)
                    {
                        // Si la route correspond à l'URL
                        if (($varsValues = $route->match($url)) !== 'false')
                            {
                                // Si elle a des variables
                                if ($route->hasVars())
                                    {
                                    //print_r('je passe ici');
                                        $varsNames = $route->varsNames();
                                        $listVars = [];

                                        // On crée un nouveau tableau clé/valeur
                                        // (clé = nom de la variable, valeur = sa valeur)
                                        foreach ($varsValues as $key => $match)
                                            {
                                                // La première valeur contient entièrement la chaine capturée (voir la doc sur preg_match)
                                                if ($key !== 0)
                                                    {
                                                        $listVars[$varsNames[$key - 1]] = $match;
                                                    }
                                            }

                                        // On assigne ce tableau de variables � la route
                                        $route->setVars($listVars);
                                    }
                                    
                                return $route;
                            }
                    }
                throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
            }
    }
