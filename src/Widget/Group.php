<?php
namespace Sirius\Renderer\Widget;

use Sirius\Forms\Html\ExtendedTag;
use \Sirius\Forms\Form;
use \Sirius\Forms\Form\Element\Specs;

class Group extends ExtendedTag
{
    use \Sirius\Forms\Widget\Traits\HasHintTrait;
    use \Sirius\Forms\Widget\Traits\HasChildrenTrait;
    
    protected $tag = 'div';

    function render() {
        $children = '';
        foreach ($this->children as $child) {
            $children .= $child;
        }
        $hint = $this->getHint() && $this->getHint()->text() ? $this->getHint() : '';
        $this->text("{$hint}{$children}");
        return parent::render();
    }
}