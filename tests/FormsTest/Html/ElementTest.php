<?php

namespace Sirius\FormsTest\Html;

use Sirius\Forms\Html\Element;

class ElementTest extends \PHPUnit_Framework_TestCase {
	
	function setUp() {
		$this->element = new Element;
	}


	function testConstructor() {
		$element = new Element(array('name' => 'email'));
		$this->assertEquals('email', $element->attr('name'));
	}
	
	function testAttributeIsSet() {
		$this->element->attr('name', 'email');
		$this->assertEquals('email', $this->element->attr('name'));
	}
	
	function testAttributeListAreRetrieved() {
		$attrs = array(
				'name' => 'email',
				'value' => 'me@domain.com',
				'id' => 'form-email'
		);
		$this->element->attr($attrs);
		$this->assertEquals(array(
			'name' => 'email',
			'value' => 'me@domain.com'
		), $this->element->attr(array('name', 'value')));
	}
	
	function testAllAttributesAreRetrieved() {
		$attrs = array(
			'name' => 'email',
			'value' => 'me@domain.com'
		);
		$this->element->attr($attrs);
		$this->assertEquals($attrs, $this->element->attr());
	}
	
	function testAttributeIsUnset() {
		$attrs = array(
			'name' => 'email',
			'value' => 'me@domain.com'
		);
		$this->element->attr($attrs);
		$this->element->attr('value', null);
		$this->assertEquals(array('name' => 'email'), $this->element->attr());
	}
	
	function testExceptionWhenAttrReceivesWrongArguments() {
		$this->setExpectedException('InvalidArgumentException');
		$this->element->attr(true);
	}

	function testAddClass() {
		$this->element->addClass('active');
		$this->assertEquals('active', $this->element->attr('class'));
		
		$this->element->addClass('disabled');
		$this->assertEquals('active disabled', $this->element->attr('class'));
	}

	function testHasClass() {
		$this->element->attr('class', 'active disabled even');
		$this->assertTrue($this->element->hasClass('active'));
		$this->assertTrue($this->element->hasClass('disabled'));
		$this->assertTrue($this->element->hasClass('even'));
		$this->assertFalse($this->element->hasClass('xdisabled'));
	}
	
	function testRemoveClass() {
		$this->element->attr('class', 'active disabled even');
		$this->element->removeClass('disabled');
		$this->assertFalse($this->element->hasClass('disabled'));
	}
	
	function testToggleClass() {
		$this->assertFalse($this->element->hasClass('active'));
		$this->element->toggleClass('active');
		$this->assertTrue($this->element->hasClass('active'));
		$this->element->toggleClass('active');
		$this->assertFalse($this->element->hasClass('active'));
	}
	
	function testTextIsSet() {
		$this->assertNull($this->element->text());
		$this->element->text('cool');
		$this->assertEquals('cool', $this->element->text());
	}
	
	function testDataIsSet() {
		// no data at the begining
		$this->assertEquals(array(), $this->element->data());
		$this->element->data('string', 'cool');
		$this->assertEquals('cool', $this->element->data('string'));
	}

	function testDataIsUnset() {
		$this->element->data('string', 'cool');
		$this->element->data('string', null);
		$this->assertNull($this->element->data('string'));
	}

	function testBulkDataIsSet() {
		$data = array(
			'k1' => 'v1',
			'k2' => 'v2'
		);
		$this->element->data($data);
		$this->assertEquals($data, $this->element->data());
	}
	
	function testDataListIsRetrieved() {
		$data = array(
			'k1' => 'v1',
			'k2' => 'v2',
			'k3' => 'v3'
		);
		$this->element->data($data);
		$this->assertEquals(array(
			'k1' => 'v1',
			'k3' => 'v3',
			'k4' => null
		), $this->element->data(array('k1', 'k3', 'k4')));
	}
	
	function testExceptionThrownWhenDataReceivesWrongArgs() {
		$this->setExpectedException('InvalidArgumentException');
		$this->element->data(new \stdClass());
	}
}