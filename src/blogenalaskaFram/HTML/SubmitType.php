<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;
use blog\HTML\Type;

/**
 * Description of SubmitType
 *
 * @author constancelaloux
 */
class SubmitType extends Type
{
    public function buildWidget()
    {
        $widget = '';
        
        if (!empty($this->errorMessage))
        {
          $widget .= $this->errorMessage.'<br />';
        }
        
        $widget .= '<input type="submit" value="'.$this->name.'"';
        
        return $widget.'/>';
    }
}
