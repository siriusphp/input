<?php
namespace Sirius\Forms\Html;

class Hidden extends Input
{

    function render()
    {
        $this->setAttribute('type', 'hidden');
        return parent::render();
    }
}