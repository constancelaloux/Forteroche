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
            new NotNullValidator('Veuillez insérer votre titre'),
        ],
        ]))
        ->add(new TextField([
        'label' => 'Contenu de l\'article',
        'name' => 'content',
        'validators' => [
            new NotNullValidator('Veuillez insérer votre texte'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'hidden',
        'label' => 'nom de l\'image',
        'name' => 'image',
        'validators' => [
            new ImageValidator('Veuillez insérer votre image'),
        ],
        ]))
        ->add(new StringField([
        'type' => 'file',
        'label' => 'Ajouter une image',
        'name' => 'slugimage',
        ]))
        ;
    }
}
