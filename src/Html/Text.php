<?php
namespace Sirius\Forms\Html;

class Text extends Input
{

    protected $tag = 'input';

    protected $isSelfClosing = true;

    protected function renderSelf()
    {
        $this->attr('value', $this->value());
        return parent::renderSelf();
    }
}