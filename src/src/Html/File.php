<?php
namespace Sirius\Forms\Html;

class File extends Input
{

    protected function renderSelf()
    {
        $this->attr('type', 'file');
        return parent::renderSelf();
    }
}