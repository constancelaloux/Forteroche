<?php

namespace blog\form;

use blog\form\Entity;
use blog\form\Form;
/**
 * Description of FormBuilder
 *
 * @author constancelaloux
 */
abstract class FormBuilder 
{
    protected $form;

    public function __construct(\blog\database\Model $entity)
    {
        $this->setForm(new Form($entity));
    }

    //référe à la fonction form du formulaire créé en php
    abstract public function form();

    public function setForm(form $form)
    {
        $this->form = $form;
    }

    //Fonction qui retourne le formulaire que l'on a créé
    public function buildform()
    {
        return $this->form;
    }
    //elle prend en paramétre l'objet form
    /*public function create()
    {
        
    }
  
    public function add(Field $field)
    {
    $attr = $field->name(); // On récupère le nom du champ.
    $field->setValue($this->entity->$attr()); // On assigne la valeur correspondante au champ.
    
    $this->fields[] = $field; // On ajoute le champ passé en argument à la liste des champs.
    return $this;
    }
    
      public function setValue($value)
  {
    if (is_string($value))
    {
      $this->value = $value;
    }
  }
  
    public function createView($form = [])
    {
        print_r($form);
        $view = '';

        foreach ($form as $key => $valu) 
        {
            foreach ($valu as $key => $value)
        {
                            echo $value;
          //$view .= $field->buildWidget().'<br />';
        }
        }
        // On génère un par un les champs du formulaire.
        foreach ($form as $key => $value)
        {
          $view .= $field->buildWidget().'<br />';
        }

        return $view;
    }*/
    
}
