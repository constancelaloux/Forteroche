<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\form;

use blog\HTML\Entity;
use blog\HTML\Form3;
/**
 * Description of FormBuilder
 *
 * @author constancelaloux
 */
abstract class FormBuilder 
{
    protected $form;

    public function __construct()
    {
        $entity = new Entity();
        $this->setForm(new Form3($entity));
    }

    abstract public function form();

    public function setForm()
    {
        $form = new Form3();
        $this->form = $form;
    }

    public function buildform()
    {
        //print_r($this->form);
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
