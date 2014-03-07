<?php
namespace Sirius\Forms\Html;

class Hidden extends Input
{

    protected function renderSelf()
    {
        $this->attr('type', 'hidden');
        return parent::renderSelf();
    }
}