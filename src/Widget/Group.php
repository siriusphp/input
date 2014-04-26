<?php
namespace Sirius\Forms\Widget;

use Sirius\Forms\Form\Element\Specs;
use Sirius\Forms\Html\ExtendedTag;
use Sirius\Forms\Widget\Traits\HasChildrenTrait;
use Sirius\Forms\Widget\Traits\HasHintTrait;

class Group extends ExtendedTag
{
    use HasHintTrait;
    use HasChildrenTrait;

    protected $tag = 'div';

    function render()
    {
        $children = '';
        foreach ($this->children as $child) {
            $children .= $child;
        }
        $hint = $this->getHint() && $this->getHint()->text() ? $this->getHint() : '';
        $this->text("{$hint}{$children}");
        return parent::render();
    }
}
