<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element as Element;

class Group extends Element
{

    function getChildren()
    {
        return $this->getForm()->getChildrenOf($this->name);
    }
}