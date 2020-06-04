<?php

namespace blog\form;

use blog\form\FormBuilder;

use blog\form\StringField;

use blog\form\TextField;

use blog\validator\NotNullValidator;

use blog\validator\ImageValidator;

/**
 * Description of ArticlesForm
 *
 * @author constancelaloux
 */
class ArticlesForm extends FormBuilder 
{
    public function form()
    {
        $this->form
        ->add(new StringField([
        'type' => 'text',
        'label' => 'Titre de l\'article',
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
        'label' => 'Contenu de l\'article',
        'name' => 'content',
        //'rows' => 300,
        //'cols' => 45,
        'validators' => [
            //new MaxLengthValidator('Identifiant trop long)', 7),
            //new MinLengthValidator('Identifiant trop court', 5),
            new NotNullValidator('Veuillez insérer votre texte'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'hidden',
        'label' => 'nom de l\'image',
        'name' => 'slugimage',
        /*'validators' => [
            //new NotNullValidator('Le format n\'est pas valide'),
            new ImageValidator('Veuillez insérer votre image'),
            //new ImageValidator('Vous devez télécharger un fichier'),
        ],*/
        ]))
        ->add(new StringField([
        'type' => 'file',
        'label' => 'Ajouter une image',
        'name' => 'image',
        /*'validators' => [
            new NotNullValidator('Veuillez insérer votre image'),
            //new ImageValidator('Veuillez insérer votre image'),
            //new ImageValidator('Vous devez télécharger un fichier'),
        ],*/
        ]))
        /*->add(new StringField([
        'type' => 'hidden',
        'label' => 'Ajouter une image',
        'name' => 'image',
        'validators' => [
            new NotNullValidator('Le format n\'est pas valide'),
            new ImageValidator('Veuillez insérer votre image'),
            new ImageValidator('Vous devez télécharger un fichier'),
        ],*/
        /*'validators' => [
            /*new MaxLengthValidator('Mot de passe pas conforme! Votre mot de passe doit '
                                        . "comporter au moins un caractére spécial, un chiffre,"
                                        . "une majuscule et minuscule, et doit etre entre 6 caractéres minimum et 8 maximum", 50),*/
            //new NotNullValidator('Veuillez insérer une image'),
        //],
        //]))
        ;
    }
}
