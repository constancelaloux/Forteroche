<?php

namespace blog\form;

use blog\form\Field;
/**
 * Description of StringField
 *
 * @author constancelaloux
 */
class StringField extends Field
{
    protected $maxLength;
    //protected $minLength;

    public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage))
        {
            $widget .= $this->errorMessage.'<br />';
        }

        $widget .= '<label for="'.$this->name.'">'.$this->label.'</label><br/><div class="input-group"><br/><input type="'.$this->type.'" name="'.$this->name.'" class="form-control" id="'.$this->name.'"';

        if (!empty($this->value))
        {
            //print_r($this->value);
            //die("meurs");
            $widget .= ' value="'.htmlspecialchars($this->value).'"';
        }

        if (!empty($this->maxLength))
        {
            $widget .= ' maxlength="'.$this->maxLength.'"';
        }
        
        /*if (!empty($this->minLength))
        {
            $widget .= ' minlength="'.$this->minLength.'"';
        }*/
        return $widget .= ' /><br/></div>';
        //return $widget .= ' />';
    }

    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;

        if ($maxLength > 0)
        {
            $this->maxLength = $maxLength;
        }
        else
        {
            throw new \RuntimeException('La longueur maximale doit être un nombre supérieur à 0');
        }
    }
}
