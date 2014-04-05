<?php
namespace Sirius\Forms\Renderer\WidgetTrait;

use Sirius\Forms\Html\ExtendedTag;

trait HasInputTrait
{

    protected $input;

    function setInput(ExtendedTag $input)
    {
        $this->input = $input;
        return $this;
    }

    function getInput()
    {
        return $this->input;
    }
}