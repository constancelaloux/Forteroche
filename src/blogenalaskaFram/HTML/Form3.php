<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;

use blog\HTML\Entity;
//use blog\HTML\Field;
/**
 * Description of Form3
 *
 * @author constancelaloux
 */
class Form3
{
    protected $entity;
    protected $fields = [];

    public function __construct()
    {
        $entity = new Entity();
        $this->setEntity($entity);
    }

    //On hydrate l'objet Field avec les valeurs données pour créer un formulaire.
    //Ensuite on assigne la valeur correspondante au champ et on génére un tableau avec les données
    public function add($field)
    {
        //print_r($field);
        $attr = $field->name(); // On récupère le nom du champ.
        //print_r($attr);
        //$field->setValue($this->entity($attr)); // On assigne la valeur correspondante au champ.
        //die("meurs");
        $this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
        //print_r($this);
        return $this;
    }
    
    //Fonction qui va permettre de générer le formulaire
    public function createView()
    {
        $view = '';
        // On génère un par un les champs du formulaire.
        foreach ($this->fields as $field)
        {
            $view .= $field->buildWidget().'<br />';
        }

        return $view .= '</p></form>';
        //$form = '';
        //print_r($field->buildForm());
            //print_r($field->buildWidget());
      // On génère un par un les champs du formulaire.
        /*foreach ($this->fields as $field)
        { print_r($this->fields);*/
        ////print_r($field->buildForm());
            //print_r($field->buildWidget());
        //$field->buildWidget();
        //$field correspond à si c'est stringField ou un autre field
            /*if($field->buildForm())
            {
                $form .= $field->buildForm().'<br />';
                //print_r($form);
            }
            else if($field->buildWidget())
            {
                $view .= $field->buildWidget().'<br />';
                //print_r($view);
            }*/
      /*  }
      //print_r($view);
      return $view;*/
    }

    public function isValid()
    {
      $valid = true;

      // On vérifie que tous les champs sont valides.
      foreach ($this->fields as $field)
      {
        if (!$field->isValid())
        {
                      print_r($this->fields);
          die("meurs");
          $valid = false;
        }
      }

      return $valid;
    }

    public function entity()
    {
      return $this->entity;
    }

    public function setEntity($entity)
    {
      $this->entity = $entity;
    }
}
