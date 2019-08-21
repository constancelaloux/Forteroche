<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Une instance de BackController nous permettra donc :
//D'exécuter une action (donc une méthode).
//D'obtenir la page associée au contrôleur.
//De modifier le module, l'action et la vue associés au contrôleur.
//Cette classe est une classe de base dont héritera chaque contrôleur. 
//Par conséquent, elle se doit d'être abstraite. Aussi, 
//il s'agit d'un composant de l'application, donc un lien de 
//parenté avec ApplicationComponent est à créer. 
//Notre constructeur se chargera dans un premier temps d'appeler le 
//constructeur de son parent. Dans un second temps, il créera une instance 
//de la classe Page qu'il stockera dans l'attribut correspondant. 
//Enfin, il assignera les valeurs au module, à l'action et à la vue 
//(par défaut la vue a la même valeur que l'action).

//Concernant la méthode execute(), comment fonctionnera-t-elle ? Son rôle 
//est d'invoquer la méthode correspondant à l'action assignée à notre objet.
// Le nom de la méthode suit une logique qui est de se nommer 
// executeNomdelaction(). Par exemple, si nous avons une action show sur 
// notre module, nous devrons implémenter la méthode executeShow() dans 
// notre contrôleur. Aussi, pour une question de simplicité, nous passerons
//  la requête du client à la méthode. En effet, dans la plupart des cas,
//   les méthodes auront besoin de la requête du client pour obtenir une 
//   donnée (que ce soit une variable GET, POST, ou un cookie).

//Je vais faire un bref rappel concernant la structure des managers. 
//Un manager, comme nous l'avons vu durant le TP des news, est divisé en 
//deux parties. La première partie est une classe abstraite listant 
//toutes les méthodes que le manager doit implémenter. La seconde partie 
//est constituée des classes qui vont implémenter ces méthodes, 
//spécifiques à chaque DAO. Pour reprendre l'exemple des news, 
//la première partie était constituée de la classe abstraite NewsManager 
//et la seconde partie de NewsManagerPDO et NewsManagerMySQLi.

//En plus du DAO, il faudra donc spécifier à notre classe gérant ces 
//managers l'API que l'on souhaite utiliser. Suivant ce qu'on lui 
//demande, notre classe nous retournera une instance de NewsManagerPDO 
//ou NewsManagerMySQLi par exemple.
namespace blogenalaska\Lib\BlogenalaskaFram;

use blogenalaska\Lib\BlogenalaskaFram\PdoConnection;
use blogenalaska\Lib\BlogenalaskaFram\Application;
use blogenalaska\Lib\BlogenalaskaFram\Page;

//La class BackController va me permettre d'apporter des variables get ou post au
//controllers de mes modules, puis ensuite de modifier une action, une vue, le module associé au controleur
abstract class BackController extends ApplicationComponent
    {
        protected $action = '';
        protected $module = '';
        protected $page = null;
        protected $view = '';
        protected $managers = null;

        public function __construct(Application $app, $module, $action)
            {
                parent::__construct($app);
                //Les controllers accéderont aux managers par la
                $this->managers = new PDOConnection(PDOConnection::connect());
                $this->page = new Page($app);

                $this->setModule($module);
                $this->setAction($action);
                $this->setView($action);
            }

        //Une instance de BackController nous permettra donc : D'exécuter
        // une action (donc une méthode).
        //Concernant la méthode execute(), comment fonctionnera-t-elle ?
        // Son rôle est d'invoquer la méthode correspondant à l'action 
        // assignée à notre objet. Le nom de la méthode suit une logique 
        // qui est de se nommer executeNomdelaction(). Par exemple, si 
        // nous avons une action show sur notre module, nous devrons 
        // implémenter la méthode executeShow() dans notre contrôleur. 
        // Aussi, pour une question de simplicité, nous passerons la 
        // requête du client à la méthode. En effet, dans la plupart 
        // des cas, les méthodes auront besoin de la requête du client
        //  pour obtenir une donnée (que ce soit une variable GET, POST,
        //   ou un cookie).
        public function execute()
            {
                $method = 'execute'.ucfirst($this->action);

                if (!is_callable([$this, $method]))
                    {
                        throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
                    }

                $this->$method($this->app->httpRequest());
            }

        //D'obtenir la page associée au contrôleur.
        public function page()
            {
                return $this->page;
            }

        
        //De modifier le module, l'action et la vue associés au contrôleur.
        public function setModule($module)
            {
                if (!is_string($module) || empty($module))
                    {
                        throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
                    }

                $this->module = $module;
            }

        public function setAction($action)
            {
                if (!is_string($action) || empty($action))
                    {
                        throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
                    }

                $this->action = $action;
            }
            
        //Cette fonction sera utilisée pour afficher une vue
        //méthode setView($view). En effet, lorsque l'on change de vue, 
        //il faut en informer la page concernée grâce à la méthode 
        //setContentFile() de notre classe Page
            
        public function setView($view)
            {
                if (!is_string($view) || empty($view))
                    {
                        throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
                    }

                $this->view = $view;
                $this->page->setContentFile(__DIR__.'/../../blogenalaska/'.$this->app->name().'/Modules/'.$this->module.'/Views/'.$this->view.'.php');
            }
    }
