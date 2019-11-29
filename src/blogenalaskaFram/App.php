<?php

//namespace, permet de dire "je travaille dans ce dossier".
namespace blog;
use blog\provider\Router;
use blog\provider\Route;
use blog\HTTPResponse;
use blog\HTTPRequest;

//use GuzzleHttp\Psr7\Response;
//use Psr\Http\Message\ResponseInterface;
//use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of App
 *
 * @author constancelaloux
 */
class App 

{
    //protected $httpRequest;
    //protected $httpResponse;
    
    /*public function __construct()
    {
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
    }*/
    
    public function run()
    {
        //$request = $_GET['url'];
        //$request = new HTTPRequest;
        //$request= $request->requestURI();
        //$request = $_SERVER['REQUEST_URI'];

        //$response = $response->addHeader(301);
        $request = new HTTPRequest();
        $response = new HTTPResponse();
        
        $uri = $request->requestURI();
        $router = new Router($uri, $response);

        require (__DIR__ . '/routes/Routes.php');
        //il faut que tu vérifies que l'url passé en paramétre correspond a une des urls
        $router->map($request);
        //Je récupére l'uri
        /*$request = new HTTPRequest();
        $uri = $request->requestURI();
                if($uri === $request->getData('/'))
        {
            $test = "nouveluri";
            return (new HTTPResponse())
                ->redirect($test);
        }
        
        if($uri === '/blog')
        {
            $response = new HTTPResponse();
            $response->write('Bienvenu sur le blog');
            return $response;
        }
        
        $response = new HTTPResponse();
        $response->write('Bonjour');
        return $response;*/
    }
        //$response = $response->withStatus(301);
        //$get = $request->getData('/');

        //$router = new Router($uri);

        //require (__DIR__ . '/routes/Routes.php');
        //il faut que tu vérifies que l'url passé en paramétre correspond a une des urls
        //$router->map();

    /*public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $_SERVER['REQUEST_URI'];
        //print_r(substr($uri, -1));
        //si l'url n'est pas vide et le dernier caractére de uri est un /
        if(!empty($uri) && (substr($uri, -1)) === "/")
        {
            return (new Response())
                    ->withStatus(301)
                    ->withHeader('location:'.substr($uri, 0, -1));
            //ca veut dire que j'ai un / en fin d'url donc je vais rediriger sur la version sans le /
            //-1 = je reviens un cran en arriére
            //print_r(header('location:'. substr($uri, 0, -1)));
            //header('location:'.substr($uri, 0, -1));
            //header('location: HTTP/1.1 301 Moved Permanently');
            //exit("je sors jamais");
        }
        $response = new Response();
        $response->getBody()->write('Bonjour');
        return $response;
        echo"hello";
    }*/
    //put your code here
}
