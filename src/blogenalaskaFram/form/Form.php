<?php

namespace blog\form;

//use blog\form\Entity;

/**
 * Description of Form3
 *
 * @author constancelaloux
 */
class Form
{
    protected $entity;
    protected $fields = [];

    public function __construct(\blog\database\Model $entity)
    {
        //$entity = new Entity();
        $this->setEntity($entity);
    }

    /**
    * On hydrate l'objet Field avec les valeurs données pour créer un formulaire.
    * Ensuite on assigne la valeur correspondante au champ et on génére un tableau avec les données
    */
    public function add(Field $field)
    {
        $attr = $field->name(); // On récupère le nom du champ.
       // print_r($this->entity($attr));
        //$field->setValue($this->entity($attr)); // On assigne la valeur correspondante au champ.
        $field->setValue($this->entity->$attr);
        /*if (isset($this->entity->$attr))
        {
            die("meurs");
            $field->setValue($this->entity->$attr);
        }*/
        $this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
        return $this;
    }
    
    /**
    * Fonction qui va permettre de générer le formulaire.
    */
    public function createView()
    {
        $view = '';
        // On génère un par un les champs du formulaire.
        foreach ($this->fields as $field)
        {
            $view .= $field->buildWidget().'<br />';
        }

        //return $view .= '</p></form>';
        //return $view .= '</form>';
        return $view;
    }

    /**
    * On vérifie que tous les champs sont valides.
    */
    public function isValid()
    {
        $valid = true;

        foreach ($this->fields as $field)
        {

            if (!$field->isValid())
            {
                $valid = false;
            }
        }
        return $valid;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function setEntity(\blog\database\Model $entity)
    {
        $this->entity = $entity;
    }
}