<?php
namespace Sirius\Input;

class AttributesContainer extends DataContainer
{

    function hasClass($className)
    {
        return (bool)preg_match('/\b' . $className . '\b/i', $this->get('class'));
    }

    function addClass($className)
    {
        if ($this->hasClass($className)) {
            return;
        }
        $this->set('class', trim($this->get('class') . ' ' . $className));
    }

    function removeClass($className)
    {
        if (! $this->hasClass($className)) {
            return;
        }
        $classes = preg_replace('/\b' . $className . '\b/i', '', $this->get('class'));
        $classes = trim(preg_replace('/[ ]+/', ' ', $classes));
        $this->set('class', $classes);
    }

    function toggleClass($className)
    {
        if ($this->hasClass($className)) {
            $this->removeClass($className);
            return;
        }
        $this->addClass($className);
    }
}