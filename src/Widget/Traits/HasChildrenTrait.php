<?php
namespace Sirius\Forms\Widget\Traits;

trait HasChildrenTrait
{

    /**
     * @var array
     */
    protected $children;

    /**
     * Set the children of this element (fielset/collection/form)
     *
     * @param array $children
     * @return $this
     */
    function setChildren($children = array())
    {
        $this->children = $children;
        return $this;
    }

    /**
     * Get the children of this element (fielset/collection/form)
     *
     * @return mixed
     */
    function getChildren()
    {
        return $this->children;
    }
}
