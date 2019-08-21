<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace blogenalaska\Frontend;
//print_r('je passe dans frontend application aussi');
use blogenalaska\Lib\BlogenalaskaFram\Application;
/**
 * Description of FrontendApplication
 *
 * @author constancelaloux
 */

class FrontendApplication  extends Application
    {
    
        //put your code here
        public function __construct()
            {
                parent::__construct();

                $this->name = 'Frontend';
            }

        public function run()
            {
                //print_r('je passe dans run aussi');
                //Obtention du contrôleur grâce à la méthode parente getController()
                $controller = $this->getController();
                //Exécution du contrôleur.
                $controller->execute();
                //print_r("je suis ici aussi hé oui");
                //Assignation de la page créée par le contrôleur à la réponse.
                $this->httpResponse->setPage($controller->page());
                //Envoi de la réponse.
                $this->httpResponse->send();
            }
    }
