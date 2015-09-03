<?php
namespace Sirius\Input;

class BaseElement extends Element
{
}

class ElementTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Element
     */
    protected $element;

    function setUp()
    {
        $this->element = new BaseElement('email');
    }

    function testSetAndGetForUndefinedProperties()
    {
        $this->element->set('key', 'value');
        $this->assertEquals('value', $this->element->get('key'));
    }

    function testSetAndGetForDefinedProperties()
    {
    	$this->assertFalse($this->element->hasClass('required'));
        $this->element->set('attributes', array('class' => 'required'));
    	$this->assertTrue($this->element->hasClass('required'));
    	$this->assertEquals('required', $this->element->get('attributes')['class']);
    }

    function testSettingAndGettingAttributes()
    {
        $attrs = array(
            'class' => 'required',
            'placeholder' => 'email@domain.com'
        );
        
        // on the element
        $this->element->setAttributes($attrs);
        $this->assertEquals($attrs, $this->element->getAttributes());
    }

    function testAttributes()
    {
        $attr = 'class';
        $value = 'required';
        
        // on the element
        $this->element->setAttribute($attr, $value);
        $this->assertEquals($value, $this->element->getAttribute($attr));
    }

    function testUnsettingAttributes()
    {
        $this->element->setAttributes(array(
            'class' => 'required'
        ));
        
        $this->element->setAttribute('class', null);
        $this->assertNull($this->element->getAttribute('class'));
    }

    function testSettingData()
    {
        $this->element->setData('key', 'value');
        $this->assertEquals('value', $this->element->getData('key'));
        $this->assertNull($this->element->getData('no_key'));
    }

    function testSettingMultipleData()
    {
        $data = array(
            'a' => 'b',
            'c' => 'd'
        );
        $this->element->setData($data);
        $this->assertEquals('b', $this->element->getData('a'));
        
        $this->assertEquals($data, $this->element->getData());
    }

    function testHandlingCssClasses()
    {
        $this->element->addClass('required');
        $this->assertEquals('required', $this->element['attributes']->get('class'));
        
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
