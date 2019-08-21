<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blogenalaska\Lib\BlogenalaskaFram;
/**
 * Description of HTTPResponse
 *
 * @author constancelaloux
 */

//Ce que l'on va renvoyer au client
class HTTPResponse extends ApplicationComponent
    {
        protected $page;
        
        //D'ajouter un header spécifique. Il est possible d'avoir différents header
        public function addHeader($header)
            {
              header($header);
            }
            
        //De rediriger l'utilisateur.
        public function redirect($location)
            {
              header('Location: '.$location);
              exit;
            }
            
        //De le rediriger vers une erreur 404.
        //On commence d'abord par créer une instance de la classe Page 
        //que l'on stocke dans l'attribut correspondant.
        //On assigne ensuite à la page le fichier qui fait office de vue 
        //à générer. Ce fichier contient le message d'erreur formaté. 
        //Vous pouvez placer tous ces fichiers dans le dossier /Errors 
        //par exemple, sous le nom code.html. Le chemin menant au fichier
        // contenant l'erreur 404 sera donc /Errors/404.html.
        //un header disant que le document est non trouvé (HTTP/1.0 404 
        //Not Found).
        //On envoie la réponse.
        public function redirect404()
            {
                $this->page = new Page($this->app);
                $this->page->setContentFile(__DIR__.'/../../Errors/404.html');

                $this->addHeader('HTTP/1.0 404 Not Found');

                $this->send();
            }
        
        //Cependant, il est bien beau d'assigner une page,encore faudrait-il pouvoir l'envoyer !
        // Voici une deuxième fonctionnalité :celle d'envoyer la réponse en générant la page.

        //D'envoyer la réponse en générant la page.
        public function send()
            {
              // Actuellement, cette ligne a peu de sens dans votre esprit.
              // Promis, vous saurez vraiment ce qu'elle fait d'ici la fin du chapitre
              // (bien que je suis sûr que les noms choisis sont assez explicites !).
              exit($this->page->getGeneratedPage());
            }
        
        //D'assigner une page à la réponse.
        public function setPage(Page $page)
            {
              $this->page = $page;
            }
            
        //Notez la valeur par défaut du dernier paramètre de la méthode setCookie() : 
        //elle est à true, alors qu'elle est à false sur la fonction setcookie() de 
        //la bibliothèque standard de PHP. Il s'agit d'une sécurité qu'il est toujours 
        //préférable d'activer.
        //J'ajoute un cookie lors du renvoi de qq chose au client
        // Changement par rapport à la fonction setcookie() : le dernier argument est par défaut à true
        public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, 
                $secure = false, $httpOnly = true)
            {
              setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
            }
    }
