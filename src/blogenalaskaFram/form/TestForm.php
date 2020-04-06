<?php

namespace blog\form;

//use blog\HTML\Form3;
use blog\HTML\StringField;
use blog\HTML\TextField;
use blog\HTML\SubmitType;
use blog\HTML\FormType;
use blog\form\FormBuilder;
use blog\validator\MaxLengthValidator;
use blog\validator\NotNullValidator;
use blog\validator\MinLengthValidator;
/**
 * Description of TestForm
 *
 * @author constancelaloux
 */
class TestForm extends FormBuilder
{
            //->createNamed
        //->setAction($this->generateUrl('target_route'))
        //->setMethod('GET')
    //Fonction dans laquelle on créé le formulaire
    public function form()
    {
        $this->form->add(new FormType([
        //'name' => 'mon formulaire de test',
        'action' => '/test',
        'method' => 'POST'
        //'nam' => 'Envoyer'
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Prenom',
        'name' => 'firstname',
        'maxLength' => 20,
        'minLength' => 5,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long)', 7),
            new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre identifiant'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Nom',
        'name' => 'surname',
        'maxLength' => 20,
        'minLength' => 5,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long)', 7),
            new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre identifiant'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Identifiant',
        'name' => 'username',
        'maxLength' => 20,
        'minLength' => 5,
        'validators' => [
            new MaxLengthValidator('Identifiant trop long)', 7),
            new MinLengthValidator('Identifiant trop court', 5),
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
            new MaxLengthValidator('Mot de passe pas conforme! Votre mot de passe doit '
                                        . "comporter au moins un caractére spécial, un chiffre,"
                                        . "une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum", 50),
            new NotNullValidator('Merci de spécifier un mot de passe'),
        ],
        ]))
        /*->add(new TextField([
        'label' => 'Contenu',
        'name' => 'contenu',
        'rows' => 7,
        'cols' => 50,
        ]))*/
        ->add(new SubmitType([
        'name' => 'Valider'
        ]));
    }  
}
