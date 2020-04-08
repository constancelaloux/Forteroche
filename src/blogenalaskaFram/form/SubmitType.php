<?php

namespace blog\form;
use blog\form\Type;

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
