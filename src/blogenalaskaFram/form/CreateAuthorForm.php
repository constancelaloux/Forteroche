<?php

namespace blog\form;


use blog\form\StringField;
use blog\form\TextField;
use blog\form\SubmitType;
use blog\form\FormType;
use blog\form\FormBuilder;
use blog\validator\MaxLengthValidator;
use blog\validator\NotNullValidator;
use blog\validator\MinLengthValidator;
use blog\validator\MajValidator;
/**
 * Description of TestForm
 *
 * @author constancelaloux
 */
class CreateAuthorForm extends FormBuilder
{
            //->createNamed
        //->setAction($this->generateUrl('target_route'))
        //->setMethod('GET')
    //Fonction dans laquelle on créé le formulaire
    public function form()
    {
        /*->add(new FormType([
        //'name' => 'mon formulaire de test',
        //'action' => '',
        'method' => 'POST'
        //'name' => 'Envoyer'
        ]))*/
        $this->form->add(new StringField([
        'type' => 'text',
        'label' => 'Prenom',
        'name' => 'firstname',
        'maxLength' => 5,
        //'minLength' => 5,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long', 2),
            //new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre prénom'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Nom',
        'name' => 'surname',
        'maxLength' => 2,
        //'minLength' => 5,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long)', 2),
            //new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre nom'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Identifiant',
        'name' => 'username',
        'maxLength' => 15,
        //'minLength' => 5,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long)', 15),
            //new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre identifiant'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'password',
        'label' => 'Mot de passe',
        'name' => 'password',
        'maxLength' => 12,
        //'minLength' => 6,
        'validators' => [
            new MaxLengthValidator('Mot de passe pas conforme! Votre mot de passe doit '
                                        . "comporter au moins un caractére spécial, un chiffre,"
                                        . "une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum", 8),
            new NotNullValidator('Merci de spécifier un mot de passe'),
            new MajValidator("Votre mot de passe doit comporter au moins une majuscule"),
            //new MinValidator("Votre mot de passe doit comporter au moins une majuscule"),
            //new MinValidator("Votre mot de passe doit comporter au moins un caractére spécial"),
        ],
        ]))
        /*->add(new TextField([
        'label' => 'Contenu',
        'name' => 'contenu',
        'rows' => 7,
        'cols' => 50,
        ]))*/
        /*->add(new SubmitType([
        'name' => 'Valider'
        ]))*/;
    }  
}
