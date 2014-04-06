<?php
namespace Sirius\Forms\Html;

use Sirius\Forms\Renderer\Widget\Base;

class Textarea extends Input
{

    protected $tag = 'textarea';

    protected $isSelfClosing = false;

    function render()
    {
        $this->setText($this->getValue());
        return parent::render();
    }
}