<?php
namespace Sirius\Forms\Renderer\WidgetTrait;

use Sirius\Forms\Html\ExtendedTag;

trait HasHintTrait
{

    protected $hint;

    function setHint(ExtendedTag $hint)
    {
        $this->hint = $hint;
        return $this;
    }

    function getHint()
    {
        return $this->hint;
    }
}