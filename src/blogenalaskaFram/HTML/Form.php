<?php
namespace blog\HTML;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use blog\HTTPRequest;
/**
 * Description of Form
 *
 * @author constancelaloux
 */
class Form 
{
    //private $data;
    private $request;
    
    /*public function __construct($data)
    {
        //$this->data = $data; 
        //$this->request = new HTTPRequest;
    }*/
    
    //Je cree un formulaire
    public function create($name, array $options = [])
    {
        $method = $options['method']??'POST';
        return <<<HTML
        <form method="'.$method.'" name="'.$name.'" id="form-'.ucfirst($name).'"></form>
HTML;
        
   }
    
    //Je cree un input
    public function input(string $type, string $key, string $label):string
    {
        //$type = isset($options['type']) ? $options['type'] : 'text';
        //$value = $this->getValue($key);
        $inputClass = 'form-control';
        return <<<HTML
            <div class="form-group">
                <label for="field{$key}">{$label}</label>
                    <input type="{$type}" id="field{$key}" class="{$inputClass}" name="{$key}"required>
            </div>
HTML;
                    
    }
    
    //Je cree un textarea
    public function textarea(string $type, string $key, string $label):string
    {
        //$value = $this->getValue($key);
        $inputClass = 'form-control';
        return <<<HTML
            <div class="form-group">
                <label for="field{$key}">{$label}</label>
                    <textarea type="{$type}" id="field{$key}" class="{$inputClass}" name="{$key}"></textarea>
            </div>
HTML;
    }
    
    //Je cree un bouton submit
    public function submit(string $label)
    {
        $buttonClass = 'btn btn-primary';
        return <<<HTML
            <button class="{$buttonClass}">{$label}</button>
HTML;
        
    }
    
    //Je recupere les valeurs
    private function getValue(string $key)
    {
        if(is_array($this->data))
        {
            return $this->data[$key] ?? null;
        }
        $method = 'get' .str_replace(' ', '', ucwords(str_replace('_',' ',$key)));
        return $this->data->$method();
        if($value instanceof \DateTimeInterface)
        {
            return $value->format('Y-m-d H:i:s');          
        }
        return $value;
    }
    
    public function process()
    {
        if($this->request->method() == 'POST')
        {
        $this->manager->save($this->form->entity());

        return true;
        }

        return false;
    }
}
