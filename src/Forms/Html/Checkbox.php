<?php
namespace Sirius\Forms\Html;

class Checkbox extends Input
{

    protected function renderSelf()
    {
        $checked = null;
        if (is_array($this->value()) && in_array($this->attr('value'), $this->value())) {
            $checked = 'checked';
        } elseif ($this->attr('value') == $this->value()) {
            $checked = 'checked';
        }
        $this->attr('checked', $checked);
        $this->attr('type', 'checkbox');
        return parent::renderSelf();
    }
}