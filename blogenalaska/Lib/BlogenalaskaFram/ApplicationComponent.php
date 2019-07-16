<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Forteroche\blogenalaska\Lib\BlogenalaskaFram;

/**
 * Description of ApplicationComponent
 *
 * @author constancelaloux
 */

//D'obtenir l'application à laquelle l'objet appartient. C'est tout !
//Cette classe se chargera juste de stocker, 
//pendant la construction de l'objet, 
//l'instance de l'application exécutée. 
//Nous avons donc une simple classe ressemblant 
//à celle-ci 
abstract class ApplicationComponent
    {
        protected $app;
  
        public function __construct(Application $app)
            {
              $this->app = $app;
            }

        public function app()
            {
              return $this->app;
            }
    }
