<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\HTML;

use blog\HTML\Field;
/**
 * Description of TextField
 *
 * @author constancelaloux
 */
class TextField extends Field
{
    protected $cols;
    protected $rows;

    public function buildWidget()
    {
        $widget = '';

        if (!empty($this->errorMessage))
        {
          $widget .= $this->errorMessage.'<br />';
        }

        $widget .= '<label for="'.$this->name.'">'.$this->label.'</label><br/><textarea name="'.$this->name.'" id="'.$this->name.'"';

        if (!empty($this->cols))
        {
          $widget .= ' cols="'.$this->cols.'"';
        }

        if (!empty($this->rows))
        {
          $widget .= ' rows="'.$this->rows.'"';
        }

        $widget .= '>';

        if (!empty($this->value))
        {
          $widget .= htmlspecialchars($this->value);
        }

        return $widget.'</textarea>';
    }

    public function setCols($cols)
    {
        $cols = (int) $cols;

        if ($cols > 0)
        {
          $this->cols = $cols;
        }
    }

    public function setRows($rows)
    {
        $rows = (int) $rows;

        if ($rows > 0)
        {
          $this->rows = $rows;
        }
    }
}
