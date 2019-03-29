<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Comment
    {
        /**
         * @var array
         */
        private $_id;
        private $_idFromArticle;
        private $_author;
        private $_content;
        private $_createdate;
        private $_updatedate;

        //ci, le constructeur demande la force et les dégâts initiaux du personnage que l'on vient de créer. 
        //Il faudra donc lui spécifier en paramétre dans pdoConnection.
        //Il ne manque plus qu'à implémenter le constructeur pour qu'on puisse directement hydrater notre objet lors de l'instanciation de la classe.
        //Pour cela, ajoutez un paramètre :$donnees. Appelez ensuite directement la méthodehydrate().

        public function __construct(array $donnees)
            {
                //print_r($donnees);
                $this->hydrate($donnees);
                //print_r("- Hydratation Article -");
                //echo '<br/>';
                //print_r($this->hydrate($donnees));
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
                    //print_r($donnees);
                    $method = 'set'.ucfirst($key);

                    //Il faut maintenant vérifier que cette méthode existe. Le this = le nom de la classe. 
                    //Si le setter correspondant existe
                    if(method_exists($this, $method))
                    {
                        //On appelle le setter
                        //La clé aura bien une valeur et donc notre personnage de la classe représenté par this.
                        //On récupére au sein du $this toutes les données de notre personnage
                        $this->$method($value);
                        //print_r($this->$method($value));
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
        
        public function idFromArticle()
            {
                return $this->_idFromArticle;
            }


        public function author()
            {
                return $this->_author;
            }
            
        public function content()
            {
                return $this->_content;
            }

        public function createdate()
            {
            //print_r("je passe par la");
                return $this->_createdate;
                //print_r($this);
            }

        public function updatedate()
            {
                return $this->_updatedate;
                //print_r($this);
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
            
        public function setIdFromArticle($idFromArticle)
            {
                $idFromArticle = (int) $idFromArticle;

                if ($idFromArticle > 0)
                    {
                        $this->_idFromArticle = $idFromArticle;
                    }
            }

        public function setAuthor($author)
            {
                //On vérifie qu'il s'agit bien d'une chaine de caractéres
                if(is_string($author))
                    {
                        $this->_author = $author;
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
                //print_r("jepassepar la");
                $this->_createdate = $createdate;
                //print_r($createdate);
            }

        public function setUpdatedate(DateTime $updatedate)
            {
                //print_r("jepassepar la");
                $this->_updatedate = $updatedate;
                //print_r($updatedate);
            }
    }
