<?php

namespace blog\form;

use blog\form\FormBuilder;

use blog\form\StringField;

use blog\form\TextField;

use blog\validator\NotNullValidator;
/**
 * Description of CommentsForm
 *
 * @author constancelaloux
 */
class CommentsForm extends FormBuilder 
{
    public function form()
    {
        $this->form
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Titre du commentaire',
        'name' => 'subject',
        'maxLength' => 50,
        'minLength' => 5,
        'validators' => [
            //new MaxLengthValidator('Identifiant trop long)', 7),
            //new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre titre'),
        ],
        ]))
        ->add(new TextField([
        'label' => 'Contenu du commentaire',
        'name' => 'content',
        //'rows' => 300,
        //'cols' => 45,
        'validators' => [
            //new MaxLengthValidator('Identifiant trop long)', 7),
            //new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre texte'),
        ],
        ]))
        /*'validators' => [
            /*new MaxLengthValidator('Mot de passe pas conforme! Votre mot de passe doit '
                                        . "comporter au moins un caractére spécial, un chiffre,"
                                        . "une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum", 50),*/
            //new NotNullValidator('Veuillez insérer une image'),
        //],
        ;
    }
}
