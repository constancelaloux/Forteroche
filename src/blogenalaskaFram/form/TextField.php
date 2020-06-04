<?php

namespace blog\form;

use blog\form\Field;
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

        $widget .= '<label for="'.$this->name.'">'.$this->label.'</label><br/><div class="form-label-group"><br/><textarea name="'.$this->name.'" class="form-control form-control-sm" id="'.$this->name.'">';

        if (!empty($this->cols))
        {
          $widget .= ' cols="'.$this->cols.'"';
        }

        if (!empty($this->rows))
        {
          $widget .= ' rows="'.$this->rows.'"';
        }
        
        //$widget .= '/>';
       // $widget .= ' </textarea></div>';
        
        if (!empty($this->value))
        {
          //$widget .=  ' value="'.htmlspecialchars($this->value);
          //$widget .= ' value="'.htmlspecialchars($this->value).'"';
            $widget .= '<value>'.htmlspecialchars($this->value).'';
        }
//$widget .= '/>';
        //return $widget.'</textarea>';
        return $widget .= ' </textarea></div>';
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
