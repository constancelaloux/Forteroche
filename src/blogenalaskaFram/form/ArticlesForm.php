<?php

namespace blog\form;

use blog\form\FormBuilder;
use blog\form\StringField;
use blog\form\TextField;
use blog\validator\NotNullValidator;
use blog\validator\ImageValidator;
use blog\config\Container;

/**
 * Description of ArticlesForm
 *
 * @author constancelaloux
 */
class ArticlesForm extends FormBuilder 
{
    public $stringField;
    
    public $textField;
    
    private $container;
    
    public function construct()
    {
        /*$services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        $this->stringField = $this->container->get(\blog\form\StringField::class);
        $this->TextField = $this->container->get(\blog\form\TextField::class);*/
    }
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
