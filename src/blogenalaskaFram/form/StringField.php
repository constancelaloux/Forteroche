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
        if($this->type === 'hidden')   
        {
            $widget .= '<div class="form-label-group"><br/><input type="'.$this->type.'" name="'.$this->name.'" class="image2" id="'.$this->name.'"';
        }
        else
        {
            $widget .= '<label for="'.$this->name.'">'.$this->label.'</label><br/><div class="form-label-group"><br/><input type="'.$this->type.'" name="'.$this->name.'" class="form-control-file form-control-sm" id="'.$this->name.'"';
        }
        
        if (!empty($this->value))
        {
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
