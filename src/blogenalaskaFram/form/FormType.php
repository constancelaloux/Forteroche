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
          $widgetForm .= $this->errorMessage.'<br />';
        }
        
        //$widgetForm .= '<Form action="" method="POST">';
        $widgetForm .= /**'<h1>'.$this->name.'</h1>*/'<Form action="'.$this->action.'" method="'.$this->method.'">';
        return $widgetForm .= '<p>';
    }
}
