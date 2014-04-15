<?php

namespace Sirius\Forms;

class BaseElement extends Element
{}

class ElementTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->element = new BaseElement();
    }

    function testSettingAndGettingAttributes()
    {
        $attrs = array(
            'class' => 'required',
            'placeholder' => 'email@domain.com'
        );

        // on the element
        $this->element->setAttributes($attrs);
        $this->assertEquals($attrs, $this->element['attributes']);
        $this->assertEquals($attrs, $this->element->getAttributes());
//        // on the label
//        $this->element->setLabelAttributes($attrs);
//        $this->assertEquals($attrs, $this->element['label_attributes']);
//        $this->assertEquals($attrs, $this->element->getLabelAttributes());
//        // on the hint
//        $this->element->setHintAttributes($attrs);
//        $this->assertEquals($attrs, $this->element['hint_attributes']);
//        $this->assertEquals($attrs, $this->element->getHintAttributes());
//        // on the container
//        $this->element->setContainerAttributes($attrs);
//        $this->assertEquals($attrs, $this->element['container_attributes']);
//        $this->assertEquals($attrs, $this->element->getContainerAttributes());

    }

    function testAttributes()
    {
        $attr = 'class';
        $value = 'required';

        // on the element
        $this->element->setAttribute($attr, $value);
        $this->assertEquals($value, $this->element->getAttribute($attr));
        // on the hint
//        $this->element->setHintAttribute($attr, $value);
//        $this->assertEquals($value, $this->element->getHintAttribute($attr));
        // on the container
//        $this->element->setContainerAttribute($attr, $value);
//        $this->assertEquals($value, $this->element->getContainerAttribute($attr));

    }

    function testUnsettingAttributes()
    {
        $this->element->setAttributes(
            array(
                'class' => 'required'
            )
        );

        $this->element->setAttribute('class', null);
        $this->assertNull($this->element->getAttribute('class'));
    }

    function testSettingAndGettingVariousItems()
    {
    }

    function testHandlingCssClasses()
    {
        $this->element->addClass('required');
        $this->assertEquals('required', $this->element['attributes']['class']);

        // adding a class twice is not possible
        $this->element->addClass('required');
        $this->assertTrue($this->element->hasClass('required'));

        $this->element->removeClass('required');
        $this->assertEquals('', $this->element->getAttribute('class'));

        $this->element->toggleClass('required');
        $this->assertTrue($this->element->hasClass('required'));
        $this->element->toggleClass('required');
        $this->assertEquals('', $this->element->getAttribute('class'));
    }

}
