<?php

namespace blog\form;
use blog\form\Type;

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
            //print_r("je passe dasns errorMessage n'est pas vide");
            $widgetForm .= $this->errorMessage.'<br />';
        }

        $widgetForm .= '<Form action="'.$this->action.'" method="'.$this->method.'">';
        //return $widgetForm .= '<p>';
        return $widgetForm;
    }
}
