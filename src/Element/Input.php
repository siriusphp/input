<?php
namespace Sirius\Forms\Element;

class Input extends Element
{  
    protected function getDefaultSpecs() {
        return array(
            Element::WIDGET => 'text',
            Element::ATTRIBUTES => array(
            	'type' => 'text'
            )
        );
    }
}