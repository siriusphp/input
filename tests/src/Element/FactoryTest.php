<?php

namespace Sirius\Forms\Element;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->factory = new Factory();
    }

    function testExceptionThrownForMissingClasses()
    {
        $this->setExpectedException('\RuntimeException');
        $this->factory->registerElementType('autocomplete', '\MyApp4589873574\Element\Input\Autocomplete');
    }

    function testExceptionThrownForWrongClasses()
    {
        $this->setExpectedException('\RuntimeException');
        $this->factory->registerElementType('autocomplete', '\ArrayObject');
    }

    function testExceptionThrownForInvalidConstructor()
    {
        $this->setExpectedException('\RuntimeException');
        $this->factory->registerElementType('autocomplete', new \stdClass());
    }

    function testElementCreationThroughClosures()
    {
        $this->factory->registerElementType(
            'autocomplete',
            function ($specs) {
                return new \Sirius\Forms\Element\Input\Select($specs);
            }
        );
        $element = $this->factory->createFromOptions(
            'city',
            array(
                'element_type' => 'autocomplete'
            )
        );
        $this->assertTrue($element instanceof \Sirius\Forms\Element\Input\Select);
    }

    function testDefaultElementCreation()
    {
        $element = $this->factory->createFromOptions('address');
        $this->assertTrue($element instanceof \Sirius\Forms\Element\Input\Text);
    }

    function testElementCreationThroughClasses()
    {
        $this->factory->registerElementType('dropdown', '\Sirius\Forms\Element\Input\Select');
        $element = $this->factory->createFromOptions(
            'city',
            array(
                'element_type' => 'dropdown'
            )
        );
        $this->assertTrue($element instanceof \Sirius\Forms\Element\Input\Select);
    }
}
