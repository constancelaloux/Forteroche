<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace blogenalaska\Lib\Vendors\Entity;
/**
 * Description of News
 *
 * @author constancelaloux
 */
//use Forteroche\blogenalaska\Lib\BlogenalaskaFram\;
class News 
    {
        protected $_author,
        $_subject,
        $_content,
        $_createdate,
        $_updatedate;
        
        /**
        * Constantes relatives aux erreurs possibles rencontrées lors de l'exécution de la méthode.
        */
        const AUTEUR_INVALIDE = 1;
        const TITRE_INVALIDE = 2;
        const CONTENU_INVALIDE = 3; 
        
        /**
            * Méthode permettant de savoir si la news est valide.
            * @return bool
        */
        public function isValid()
            {
                return !(empty($this->auteur) || empty($this->titre) || empty($this->contenu));
            }
        //Actuellement, les attributs de nos objets sont inaccessibles. 
        //Il faut créer des getters pour pouvoir les lire, et des setters pour pouvoir 
        //modifier leurs valeurs.  
        
            
        //liste des setters 
        //un setter est une méthode chargée d'assigner une valeur à un attribut en vérifiant 
        //son intégrité (si vous assignez la valeur sans aucun contrôle, vous perdez tout l'intérêt 
        //qu'apporte le principe d'encapsulation).
        public function setAuthor($author)
            {
                //On vérifie qu'il s'agit bien d'une chaine de caractéres
                //Et s'il est vide ou pas
                if(is_string($author) || empty($author))
                    {
                        $this->errors[] = self::AUTEUR_INVALIDE;
                    }
                $this->author = $author;
            }

        public function setSubject($subject)
            {
                if(is_string($subject) || empty($subject))
                    {
                        $this->errors[] = self::TITRE_INVALIDE; 
                    }
                $this->subject = $subject;
            }

        public function setContent($content)
            {
                if(is_string($content) || empty($content))
                    {
                        $this->errors[] = self::CONTENU_INVALIDE;   
                    }
                $this->content = $content;
            }
            
        //public function setCreatedate(DateTime $createdate)
        public function setCreatedate($createdate)
            {              
                if(is_string($createdate))
                    {
                        $this->createdate = $createdate;           
                    }
            }

        public function setUpdatedate($updatedate)
            {
                if(is_string($updatedate))
                    {
                        $this->updatedate = $updatedate;  
                    }
            }
            
        // Liste des getters. 
        // Je pourrais réutiliser les fonctions par la suite. 
        // un getter est une méthode chargée de renvoyer la valeur d'un attribut
        public function author()
            {
                return $this->_author;
            }

        public function subject()
            {
                return $this->_subject;
            }
            
        public function content()
            {
                return $this->_content;
            }

        public function createdate()
            {
                return $this->_createdate;
            }

        public function updatedate()
            {
                return $this->_updatedate;
            }
    }
