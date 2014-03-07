<?php

namespace Sirius\Forms\Element;

class SpecsTest extends \PHPUnit_Framework_TestCase {
	
	function setUp() {
		$this->specs = new Specs();
	}

	function testSettingAndGettingAttributes() {
		$attrs = array(
			'class' => 'required',
			'placeholder' => 'email@domain.com'
		);

		// on the element
		$this->specs->setAttributes($attrs);
		$this->assertEquals($attrs, $this->specs['attributes']);
		$this->assertEquals($attrs, $this->specs->getAttributes());
		// on the label
		$this->specs->setLabelAttributes($attrs);
		$this->assertEquals($attrs, $this->specs['label_attributes']);
		$this->assertEquals($attrs, $this->specs->getLabelAttributes());
		// on the hint
		$this->specs->setHintAttributes($attrs);
		$this->assertEquals($attrs, $this->specs['hint_attributes']);
		$this->assertEquals($attrs, $this->specs->getHintAttributes());
		// on the container
		$this->specs->setContainerAttributes($attrs);
		$this->assertEquals($attrs, $this->specs['container_attributes']);
		$this->assertEquals($attrs, $this->specs->getContainerAttributes());

		// make sure retrieving attributes returns an array
		$this->assertEquals(array(), $this->specs->getFormAttributes());
	}

	function testSettingAndGettingSingleAttribute() {
		$attr = 'class';
		$value = 'required';

		// on the element
		$this->specs->setAttribute($attr, $value);
		$this->assertEquals($value, $this->specs->getAttribute($attr));
		// on the label
		$this->specs->setLabelAttribute($attr, $value);
		$this->assertEquals($value, $this->specs->getLabelAttribute($attr));
		// on the hint
		$this->specs->setHintAttribute($attr, $value);
		$this->assertEquals($value, $this->specs->getHintAttribute($attr));
		// on the container
		$this->specs->setContainerAttribute($attr, $value);
		$this->assertEquals($value, $this->specs->getContainerAttribute($attr));

	}

	function testUnsettingAttributes() {
		$this->specs->setAttributes(array(
			'class' => 'required'
		));

		$this->specs->setAttribute('class', null);
		$this->assertNull($this->specs->getAttribute('class'));
	}

	function testSettingAndGettingVariousItems() {
		// simple string
		$this->specs->setLabel('Username');
		$this->assertEquals('Username', $this->specs['label']);
		$this->assertEquals('Username', $this->specs->getLabel());

		// complex string
		$this->specs->setErrorMessage('Field is required');
		$this->assertEquals('Field is required', $this->specs['error_message']);
		$this->assertEquals('Field is required', $this->specs->getErrorMessage());
	}

	function testHandlingCssClasses() {
		$this->specs->addClass('required');
		$this->assertEquals('required', $this->specs['attributes']['class']);

		// adding a class twice is not possible
		$this->specs->addClass('required');
		$this->assertEquals('required', $this->specs['attributes']['class']);

		$this->specs->removeClass('required');
		$this->assertEquals('', $this->specs['attributes']['class']);

		$this->specs->toggleClass('required');
		$this->assertEquals('required', $this->specs['attributes']['class']);
		$this->specs->toggleClass('required');
		$this->assertEquals('', $this->specs['attributes']['class']);
	}

}