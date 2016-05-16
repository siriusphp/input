<?php
namespace Sirius\Input;

class AttributesContainer extends DataContainer
{

    public function hasClass($className)
    {
        return (bool) preg_match('/\b' . $className . '\b/i', $this->get('class'));
    }

    public function addClass($className)
    {
        if ($this->hasClass($className)) {
            return;
        }
        $this->set('class', trim($this->get('class') . ' ' . $className));
    }

    public function removeClass($className)
    {
        if (!$this->hasClass($className)) {
            return;
        }
        $classes = preg_replace('/\b' . $className . '\b/i', '', $this->get('class'));
        $classes = trim(preg_replace('/[ ]+/', ' ', $classes));
        $this->set('class', $classes);
    }

    public function toggleClass($className)
    {
        if ($this->hasClass($className)) {
            $this->removeClass($className);

            return;
        }
        $this->addClass($className);
    }
}