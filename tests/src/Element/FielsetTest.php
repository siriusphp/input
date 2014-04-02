<?php

namespace Sirius\Forms\Element;

use Sirius\Forms\Element\Factory;

class FieldsetTest extends \PHPUnit_Framework_TestCase {
    
    function setUp() {
        $this->input = new Fieldset('address');
        $this->input->setElementFactory(new Factory);
    }
    
    function testAddingElements() {
        $this->input->add('city', array('priority' => 2));
        $this->input->add('street', array('priority' => 1));
        $this->input->add('state', array('priority' => 2));
        
        $children = $this->input->getChildren();
        $elementNames = array_keys($children);
        
        // test the element are in the correct order
        $this->assertEquals('address[street]', $elementNames[0]);
        $this->assertEquals('address[city]', $elementNames[1]);
        $this->assertEquals('address[state]', $elementNames[2]);
    }
    
    function testRemovingElements() {
        $this->assertFalse($this->input->has('city'));
        $this->input->add('city', array('priority' => 2));
        $this->assertTrue($this->input->has('city'));
        
        $this->input->remove('city');
        
        $this->assertEquals(0, count($this->input->getChildren()));
    }
    
    function testDeepElement() {
        $this->input->add('country[code]', array());
        $this->assertEquals('address[country][code]', $this->input->get('country[code]')->getName());
    }
}