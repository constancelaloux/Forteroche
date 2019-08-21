<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blogenalaska\Lib\BlogenalaskaFram;

/**
 * Description of Page
 *
 * @author constancelaloux
 */
class Page extends ApplicationComponent
    {
        protected $contentFile;
        protected $vars = [];
        
        //Je fais passer les variables
        public function addVar($var, $value)
            {
                if (!is_string($var) || is_numeric($var) || empty($var))
                    {
                        throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
                    }

                $this->vars[$var] = $value;
            }
        
        //De générer la page avec le layout de l'application.
        public function getGeneratedPage()
            {
                if (!file_exists($this->contentFile))
                    {
                        throw new \RuntimeException('La vue spécifiée n\'existe pas');
                    }

                extract($this->vars);

                ob_start();
                require $this->contentFile;
                $content = ob_get_clean();

                ob_start();
                require __DIR__.'/../../blogenalaska/'.$this->app->name().'/Templates/layout.php';
                return ob_get_clean();
            }
        
        //D'assigner une vue à la page.
        public function setContentFile($contentFile)
            {
                if (!is_string($contentFile) || empty($contentFile))
                    {
                        throw new \InvalidArgumentException('La vue spécifiée est invalide');
                    }

                $this->contentFile = $contentFile;
            }
    }
