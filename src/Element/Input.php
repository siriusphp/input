<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element as BaseElement;

class Input extends BaseElement
{  
    protected function getDefaultSpecs() {
        return array(
            BaseElement::WIDGET => 'text',
            BaseElement::ATTRIBUTES => array(
            	'type' => 'text'
            )
        );
    }
}