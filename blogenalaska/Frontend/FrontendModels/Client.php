<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Client
    {
        /**
         * @var array
         */
        // La classePersonnagea pour rôle de représenter un personnage présent en BDD. Elle n'a en aucun cas pour rôle de les gérer.
        //attributs
        private $_id;
        private $_password;
        private $_username;
        private $_surname;
        private $_firstname;
        private $_imageComment;

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


        public function password()
            {
                return $this->_password;
            }

        public function username()
            {
                return $this->_username;
            }

        public function surname()
            {
                return $this->_surname;
            }

        public function firstname()
            {
                return $this->_firstname;
            }

        public function imageComment()
            {
                return $this->_imageComment;
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

        public function setSurname($surname)
            {
                //On vérifie qu'il s'agit bien d'une chaine de caractéres
                if(is_string($surname))
                    {
                        //L'attribut de l'admin manager sera = a $surname. 
                        //Il aura la valeur de la variable $surname
                        $this->_surname = $surname;
                    }
            }

        public function setPassword($password)
            {
                if(is_string($password))
                    {
                        $this->_password = $password;
                    }
            }

        public function setUsername($username)
            {
                if(is_string($username))
                    {
                        $this->_username = $username;
                    }
            }

        public function setFirstname($firstname)
            {
                if(is_string($firstname))
                    {
                        $this->_firstname = $firstname;
                    }
            }
            
        public function setImageComment($imageComment)
            {
                if(is_string($imageComment))
                    {
                        $this->_imageComment = $imageComment;
                    }
            }
    }
