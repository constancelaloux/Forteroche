<?php

namespace blog\form;

//use blog\HTML\Form3;
use blog\HTML\StringField;
use blog\HTML\TextField;
use blog\HTML\SubmitType;
use blog\HTML\FormType;
use blog\form\FormBuilder;
/**
 * Description of TestForm
 *
 * @author constancelaloux
 */
class TestForm extends FormBuilder
{
    //Fonction dans laquelle on créé le formulaire
    public function form()
    {
        //->createNamed
        //->setAction($this->generateUrl('target_route'))
        //->setMethod('GET')
        $this->form->add(new FormType([
        'name' => 'mon formulaire de test',
        'action' => '/test',
        'method' => 'POST'
        //'nam' => 'Envoyer'
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Auteur',
        'name' => 'auteur',
        'maxLength' => 50,
        ]))
        ->add(new TextField([
        'label' => 'Contenu',
        'name' => 'contenu',
        'rows' => 7,
        'cols' => 50,
        ]))
        ->add(new SubmitType([
        'name' => 'Valider'
        ]));
    }  
}
