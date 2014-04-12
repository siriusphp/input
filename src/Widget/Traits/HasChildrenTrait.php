<?php
namespace Sirius\Forms\Widget\Traits;

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
