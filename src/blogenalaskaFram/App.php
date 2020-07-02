<?php

/**
 * namespace, permet de dire "je travaille dans ce dossier".
 */
namespace blog;
use blog\provider\Router;
use blog\provider\Route;
use blog\HTTPResponse;
use blog\HTTPRequest;

/**
 * Description of App
 *
 * @author constancelaloux
 */
class App 

{
    
    /**
    * Permet de récupérer L'URI qui a été fourni pour accéder à cette page et ensuite
    * le router a besoin de l'URI qui sera la requéte et de l'objet reponse pour fonctionner
    * @author constancelaloux
    */
    public function run()
    {
        $request = new HTTPRequest();
        $response = new HTTPResponse();
        
        $uri = $request->requestURI();

        $router = new Router($uri, $response);
        require (__DIR__ . '/routes/Routes.php');
        /**
         * il faut que tu vérifies que l'url passé en paramétre correspond a une des urls
         */
        $router->map($request);
    }
}
