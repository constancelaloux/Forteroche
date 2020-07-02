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

    /**
     * référe à la fonction form du formulaire créé en php
     */
    abstract public function form();

    public function setForm(form $form)
    {
        $this->form = $form;
    }

    /**
     * Fonction qui retourne le formulaire que l'on a créé
     */
    public function buildform()
    {
        return $this->form;
    }
}
