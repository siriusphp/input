<?php
namespace Sirius\Forms\Renderer\WidgetTrait;

use Sirius\Forms\Html\ExtendedTag;

trait HasChildrenTrait
{

    protected $children;

    function setChildren($children = array())
    {
        $this->children = $children;
        return $this;
    }

    function getChildren()
    {
        return $this->children;
    }
}