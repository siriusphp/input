<?php

namespace Sirius\Forms\Element;

use Sirius\Forms\Element\Factory;

class CollectionTest extends \PHPUnit_Framework_TestCase {
    
    function setUp() {
        $this->input = new Collection('invoice_lines');
        $this->input->setElementFactory(new Factory);
    }
    
    function testAddingElements() {
        $this->input->add('quantity', array('priority' => 2));
        $this->input->add('product', array('priority' => 1));
        $this->input->add('price', array('priority' => 2));
        
        $children = $this->input->getChildren();
        $elementNames = array_keys($children);
        
        // test the element are in the correct order
        $this->assertEquals('invoice_lines[*][product]', $elementNames[0]);
        $this->assertEquals('invoice_lines[*][quantity]', $elementNames[1]);
        $this->assertEquals('invoice_lines[*][price]', $elementNames[2]);
    }
    
    function testRemovingElements() {
        $this->assertFalse($this->input->has('product'));
        $this->input->add('product', array('priority' => 2));
        $this->assertTrue($this->input->has('product'));
        
        $this->input->remove('product');
        
        $this->assertEquals(0, count($this->input->getChildren()));
    }
    
    function testDeepElement() {
        $this->input->add('discount[percentage]', array());
        $this->assertEquals('invoice_lines[*][discount][percentage]', $this->input->get('discount[percentage]')->getName());
    }
}