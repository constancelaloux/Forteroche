<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;
use blog\HTML\Type;

/**
 * Description of FormField
 *
 * @author constancelaloux
 */
class FormType  extends Type
{
    public function buildWidget()
    {
        $widgetForm = '';
        
        if (!empty($this->errorMessage))
        {
          $widgetForm .= $this->errorMessage.'<br />';
        }
        
        $widgetForm .= /**'<h1>'.$this->name.'</h1>*/'<Form action="'.$this->action.'" method="'.$this->method.'">';
        return $widgetForm .= '<p>';
        //return $widgetForm.'</form>';
    }
}
