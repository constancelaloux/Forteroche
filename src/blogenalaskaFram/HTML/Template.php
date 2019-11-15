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
    private $assignedValues = array();
    private $tpl;
    
    public function __construct($path = '')
    {
        if(!empty($path))
        {
            if(file_exists($path))
            {
                $this->tpl = file_get_contents($path);
            }
            else
            {
                echo"template error: file inclusion error";
            }
        }
    }
    // Get the template file
    public function assign($searchString, $replaceString)
    {
        if(!empty($searchString))
        {
            $this->assignedValues[$searchString] = $replaceString;
        }
    }
    
    public function show()
    {
        if(count($this->assignedValues) > 0)
        {
            foreach ($this->assignedValues as $key => $value)
            {
                $this->tpl = str_replace('{'.$key.'}', $value, $this->tpl);
                //print_r($this->tpl);
            }
        }
        
        echo $this->tpl;
    }
}
