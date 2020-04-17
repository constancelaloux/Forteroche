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
        
        //$widget .= '<input type="submit" value="'.$this->name.'"';
        $widget .= '<button type= "submit" class="btn btn-primary btn-round btn-lg btn-block">'.$this->name.'</button>';
        
        //return $widget.'/>';
        return $widget;
    }
}
