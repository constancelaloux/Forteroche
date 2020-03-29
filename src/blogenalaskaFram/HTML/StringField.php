<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;

use blog\HTML\Field;
/**
 * Description of StringField
 *
 * @author constancelaloux
 */
class StringField extends Field
{
    protected $maxLength;

    public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage))
        {
          $widget .= $this->errorMessage.'<br />';
        }

        $widget .= '<label>'.$this->label.'</label><input type="'.$this->type.'" name="'.$this->name.'"';

        if (!empty($this->value))
        {
          $widget .= ' value="'.htmlspecialchars($this->value).'"';
        }

        if (!empty($this->maxLength))
        {
          $widget .= ' maxlength="'.$this->maxLength.'"';
        }
        //print_r($widget .= ' />');
        return $widget .= ' />';
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
