<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Article
    {
        /**
         * @var array
         */
        private $_id;
        private $_author;
        private $_subject;
        private $_content;
        private $_createdate;
        private $_updatedate;

        //ci, le constructeur demande la force et les dégâts initiaux du personnage que l'on vient de créer. 
        //Il faudra donc lui spécifier en paramétre dans pdoConnection.
        //Il ne manque plus qu'à implémenter le constructeur pour qu'on puisse directement hydrater notre objet lors de l'instanciation de la classe.
        //Pour cela, ajoutez un paramètre :$donnees. Appelez ensuite directement la méthodehydrate().

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
                    //print_r($method);

                    //Il faut maintenant vérifier que cette méthode existe. Le this = le nom de la classe. 
                    //Si le setter correspondant existe
                    if(method_exists($this, $method))
                    {
                        //print_r("test");
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


        public function author()
            {
                return $this->_author;
            }

        public function subject()
            {
                //print_r("je suis la");
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

        public function setAuthor($author)
            {
                //On vérifie qu'il s'agit bien d'une chaine de caractéres
                if(is_string($author))
                    {
                        //L'attribut de l'admin manager sera = a $surname. 
                        //Il aura la valeur de la variable $surname
                        $this->_author = $author;
                        //print_r("je suis aussi ici c cool");

                    }
            }

        public function setSubject($subject)
            {
                if(is_string($subject))
                {
                    $this->_subject = $subject;
                }
            }

        public function setContent($content)
            {
                if(is_string($content))
                {
                    $this->_content = $content;
                }
            }

        public function setCreatedate(DateTime $createdate)
            {
                if(is_string($createdate))
                    {
                        $this->_createdate = $createdate;
                    }
            }

        public function setUpdatedate($updatedate)
            {
                if(is_string($updatedate))
                    {
                        $this->_updatedate = $updatedate;
                    }
            }
    }
