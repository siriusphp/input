<?php
namespace Sirius\Forms\Html;

class Text extends Input
{

    protected $tag = 'input';

    protected $isSelfClosing = true;

    function render()
    {
        $this->setAttribute('value', $this->getValue());
        return parent::render();
    }
}