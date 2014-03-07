<?php
namespace Sirius\Forms\Html;

class Radio extends Input
{

    protected function renderSelf()
    {
        $checked = $this->value() == $this->attr('value') ? 'checked' : null;
        $this->attr('checked', $checked);
        $this->attr('type', 'radio');
        return parent::renderSelf();
    }
}