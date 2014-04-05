<?php
namespace Sirius\Forms\Renderer\WidgetTrait;

use Sirius\Forms\Html\ExtendedTag;

trait HasLabelTrait
{

    protected $label;

    function setLabel(ExtendedTag $label)
    {
        $this->label = $label;
        return $this;
    }

    function getLabel()
    {
        return $this->label;
    }
}