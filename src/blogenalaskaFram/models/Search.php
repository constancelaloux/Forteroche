<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendModels;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Search
 *
 * @author constancelaloux
 */
class Search 
    {
        private $_id;
        private $_mySearchWords;
        private $_subject;
        //put your code here
        
        public function __construct(array $donnees)
            {
                $this->hydrate($donnees);
            }

        //Hydratation = assigner des valeurs aux attributs passées en paramétres. 
        //Un tableau de données doit etre passé à la fonction(d'ou le préfixe "array")
        //celle-ci doit permettre d'assigner aux attributs de l'objet les valeurs correspondantes, passées en paramètre dans un tableau
        public function hydrate(array $donnees)
            {  
                foreach($donnees as $key => $value)
                {
                    //On va chercher la fonction du setter (on la reconnait grace à la maj apres le setter).
                    //On va donner une valeur à la clé grace à la fonction
                    //On récupére les setters
                    $method = 'set'.ucfirst($key);

                    //Il faut maintenant vérifier que cette méthode existe. Le this = le nom de la classe. 
                    //Si le setter correspondant existe
                    if(method_exists($this, $method))
                        {
                            //On appelle le setter
                            //La clé aura bien une valeur et donc notre personnage de la classe représenté par this.
                            //On récupére au sein du $this toutes les données de notre personnage
                            $this->$method($value);
                        }
                }
            }
        //Actuellement, les attributs de nos objets sont inaccessibles. 
        //Il faut créer des getters pour pouvoir les lire, et des setters pour pouvoir modifier leurs valeurs.
        // Liste des getters. Je pourrais réutiliser les fonctions par la suite. 
        // un getter est une méthode chargée de renvoyer la valeur d'un attribut
        public function id()
            {
                return $this->_id;
            }
        
        public function mySearchWords()
            {
            //print_r("je suis la");
            //print_r($this->_mySearchWords);
                return $this->_mySearchWords;
                //print_r($expression);
            }
        public function subject()
            {
            //print_r("je suis la");
            //print_r($this->_mySearchWords);
                return $this->_subject;
                //print_r($expression);
            }
            
        //liste des setters 
        //un setter est une méthode chargée d'assigner une valeur à un attribut en vérifiant son intégrité (si vous assignez la valeur sans aucun contrôle, vous perdez tout l'intérêt qu'apporte le principe d'encapsulation).
        public function setId($id)
            {
                $id = (int) $id;

                if ($id > 0)
                    {
                        $this->_id = $id;
                    }
            }
            
        public function setMySearchWords($mySearchWords)
            {
                if(is_string($mySearchWords))
                    {
                        $this->_mySearchWords = $mySearchWords;
                        //print_r($this->_mySearchWords = $mySearchWords);
                    }
            }
        
        public function setSubject($subject)
            {
                if(is_string($subject))
                    {
                        $this->_subject = $subject;
                        //print_r($this->_mySearchWords = $mySearchWords);
                    }
            }
            

    }
