<?php
namespace Sirius\Forms\Html;

class File extends Input
{

    function render()
    {
        $this->setAttribute('type', 'file');
        return parent::render();
    }
}