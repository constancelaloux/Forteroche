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
        $this->form
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Identifiant',
        'name' => 'username',
        'maxLength' => 20,
        'minLength' => 5,
        'validators' => [
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
            new NotNullValidator('Merci de spécifier un mot de passe'),
        ],
        ]))
        ;
    }
}
