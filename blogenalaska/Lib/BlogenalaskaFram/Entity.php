<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blogenalaska\Lib\BlogenalaskaFram;

/**
 * Description of Entity
 *
 * @author constancelaloux
 */
class Entity implements \ArrayAccess
    {
        protected   $erreurs = [],
                    $id;
        //Implémentation d'un constructeur qui hydratera l'objet si un 
        //tableau de valeurs lui est fourni.
        public function __construct(array $donnees = [])
            {
                if (!empty($donnees))
                    {
                        $this->hydrate($donnees);
                    }
            }

        //Implémentation d'une méthode qui permet de vérifier si 
        //l'enregistrement est nouveau ou pas. Pour cela, on vérifie 
        //si l'attribut $id est vide ou non (ce qui inclut le fait que 
        //toutes les tables devront posséder un champ nommé id).
        public function isNew()
            {
                return empty($this->id);
            }
        
        //Implémentation des getters / setters.
        public function erreurs()
            {
                return $this->erreurs;
            }

        public function id()
            {
                return $this->id;
            }

        public function setId($id)
            {
                $this->id = (int) $id;
            }

        public function hydrate(array $donnees)
            {
                foreach ($donnees as $attribut => $valeur)
                    {
                        $methode = 'set'.ucfirst($attribut);

                        if (is_callable([$this, $methode]))
                            {
                                $this->$methode($valeur);
                            }
                    }
            }
        
        //Implémentation de l'interface ArrayAccess (ce n'est pas 
        //obligatoire, c'est juste que je préfère utiliser l'objet comme 
        //un tableau dans les vues).
        public function offsetGet($var)
            {
                if (isset($this->$var) && is_callable([$this, $var]))
                    {
                        return $this->$var();
                    }
            }

        public function offsetSet($var, $value)
            {
                $method = 'set'.ucfirst($var);

                if (isset($this->$var) && is_callable([$this, $method]))
                    {
                        $this->$method($value);
                    }
            }

        public function offsetExists($var)
            {
                return isset($this->$var) && is_callable([$this, $var]);
            }

        public function offsetUnset($var)
            {
                throw new \Exception('Impossible de supprimer une quelconque valeur');
            }
}
