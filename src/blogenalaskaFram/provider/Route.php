<?php

namespace blog\provider;

/**
 * Description of Route
 *
 * @objet qui représente une route
 */

class Route 
{
    //Correspond au chemin de l'url
    private $path;
    
    //Correspond au nom du controller et de sa fonction que l'on inscrit dans la route
    private $callable;
    
    private $matches = [];
    
    //Correspond aux paramétres de l'url que l'on ajoute. Id, etc
    private $params = [];

    
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/'); // On retire les / inutiles

        $this->callable = $callable;
    }
    
    //Dans le cas ou mes routes ont des paramétres
    public function with($param, $regex)
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this; // On retourne tjrs l'objet pour enchainer les arguments
    }
    
    //Je vérifie si dans le tableau des routes il y a une route qui correspond à l'url
    public function match($request)
    {
        //print_r($request);
        //on enléve les / initiaux et finaux de l'url
        //Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
        $request = trim($request, '/');
        //print_r($request);

        //On remplace le :id par une expression réguliére
        //attention si j'ai un paramétre il faut le remplacer par une expression réguliére
        //On veut le remplacer par n'importe quoi qui ne soit pas un slash / et on le remplace dans le path qui soit en paramétre
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        //print_r($path);
        //On veut transformer ca en expression réguliére qui vérifiera la chaine
        //i = case sensitive
        //Le drapeau i permet de vérifier les maj et les minuscules
        $regex = "#^$path$#i";
        //print_r($regex);
        
        //si l'url ne correspond pas
        if(!preg_match($regex, $request, $matches))
        {
            //print_r("c'est ici que je passe");
            return false;
        }
        
        //sinon il détecte l'url
        array_shift($matches);
        $this->matches = $matches;  // On sauvegarde les paramètre dans l'instance pour plus tard
        
        //Si l'url correspond, je retourne true
        return true;
    }
    
    //Dans la cas ou j'ai un paramétre
    private function paramMatch($match)
    {
        //si jamais j'ai dans mes params un param qui correspond à l'id, alors 
        if(isset($this->params[$match[1]]))
        {
            return '(' . $this->params[$match[1]].')';
        }
        return '([^/]+)';
    }
    
    //Ensuite, on va ajouter une méthode permettant d'éxécuter la fonction 
    //anonyme en lui passant les paramètres récupérés lors du preg_match().
    //J'ai un tableau avec le controller et sa fonction, et ensuite
    //Je récupére le controller correspondans et je créé une instance pour appeller sa fonction
    public function call()
    {
        //Si le nom du controller et sa fonction sont bien des strings
        //return call_user_func_array($this->callable, $this->matches);
        if(is_string($this->callable))
        {
            //Alors g deux éléments dans mon tableau. Le nom du controller et la fonction
            $params = explode('#', $this->callable);

            //Je vais vers le controller correspond au nom du controller qui dans le tableau est param index 0
            $controller = "blog\\controllers\\" . $params[0] . "Controller";
            
            //Je créé une instance de controller comme ca je peux faire appel à sa fonction
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        }
        else
        {
            return call_user_func_array($this->callable, $this->matches);
        }
        
        /*if ($e->getCode() == Router::NO_ROUTE)
            {
              // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
              $this->httpResponse->redirect404();
            }*/
    }
    
    public function getUrl($params)
    {
        $path = $this->path;
        foreach($params as $k => $v)
        {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}
