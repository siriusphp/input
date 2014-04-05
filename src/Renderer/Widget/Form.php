<?php
namespace Sirius\Renderer\Widget;

use Sirius\Forms\Html\ExtendedTag;
use \Sirius\Forms\Form;
use \Sirius\Forms\Form\Element\Specs;

class Form extends ExtendedTag
{
    use\Sirius\Forms\Renderer\WidgetTrait\HasHintTrait;
    use\Sirius\Forms\Renderer\WidgetTrait\HasChildrenTrait;
    
    protected $tag = 'form';

    function render() {
        $content = '';
        foreach ($this->children as $child) {
            $content .= $child;
        }
        $this->text($content);
        return parent::render();
    }
}