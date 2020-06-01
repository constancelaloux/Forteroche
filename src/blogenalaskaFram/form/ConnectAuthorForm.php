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

/**
 * Description of ConnectForm
 *
 * @author constancelaloux
 */
class ConnectAuthorForm extends FormBuilder
{
    public function form()
    {
        $this->form/*->add(new FormType([
        //'name' => 'mon formulaire de connexion',
        'action' => '/validateAuthorConnexion',
        'method' => 'POST'
        //'nam' => 'Envoyer'
        ]))  */
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Identifiant',
        'name' => 'username',
        'maxLength' => 20,
        'minLength' => 5,
        'validators' => [
            //new MaxLengthValidator('Identifiant trop long)', 7),
            //new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre identifiant'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'password',
        'label' => 'Mot de passe',
        'name' => 'password',
        'maxLength' => 8,
        'minLength' => 6,
        'validators' => [
            /*new MaxLengthValidator('Mot de passe pas conforme! Votre mot de passe doit '
                                        . "comporter au moins un caractére spécial, un chiffre,"
                                        . "une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum", 50),*/
            new NotNullValidator('Merci de spécifier un mot de passe'),
        ],
        ]))
        /*->add(new SubmitType([
        'name' => 'Valider'
        ]) */
        ;
    }
}