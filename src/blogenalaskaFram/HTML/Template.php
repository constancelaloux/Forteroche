<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;

/**
 * Description of Template
 *
 * @author constancelaloux
 */
class template
{
    //private $vars = array();
    private $assignedValues = array();
    private $temporaryBuffer;
    private $tpl;
    
    public function __construct($path = '')
    {
        if(!empty($path))
        {
            if(file_exists($path))
            {
                $this->tpl = file_get_contents($path);
                //print_r($this->tpl);
            }
            else
            {
                echo"template error: file inclusion error";
            }
        }
    }
    // Get the template file
    public function assign($searchString, $replaceString)
    {   //print_r($searchString);
        //print_r($replaceString);
        if(!empty($searchString))
        {
            //print_r($this->assignedValues[$searchString] = $replaceString);
            $this->assignedValues[$searchString] = $replaceString;   
        }
    }
    
    
    public function show()
    {
        
        if(count($this->assignedValues) > 0)
        {
            //print_r($this->assignedValues);
            foreach ($this->assignedValues as $firstkey => $value)
            {
                if(is_array($value))
                {
                    foreach ($value as $key => $value) 
                    {
                        $this->tpl = str_replace('{{'.$firstkey.'.'.$key.'}}', htmlspecialchars($value, ENT_QUOTES, 'UTF-8'), $this->tpl);
                    }
                }
                else if(is_object($value))
                {
                    //var_dump(get_class_methods($value));
                    foreach ($value as $key => $value) 
                    {
                        //print_r("je ne suis pas la");
                        $this->tpl = str_replace('{{'.$firstkey.'.'.$key.'}}', htmlspecialchars($value), $this->tpl);
                        
                    }
                }
                else
                {
                    $this->tpl = str_replace('{{'.$firstkey.'}}', htmlspecialchars($value), $this->tpl);
                }
            }
        }
        
        echo $this->tpl;
    }
}
