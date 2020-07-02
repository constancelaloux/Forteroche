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
            new NotNullValidator('Veuillez insérer votre titre'),
        ],
        ]))
        ->add(new TextField([
        'label' => 'Contenu du commentaire',
        'name' => 'content',
        'validators' => [
            new NotNullValidator('Veuillez insérer votre texte'),
        ],
        ]))
        ;
    }
}
