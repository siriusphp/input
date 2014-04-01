<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;

class TextareaTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Textarea('comment');

		$this->assertEquals('textarea', $input[Element::WIDGET]);
		$this->assertEquals(5, $input[Element::ATTRIBUTES]['rows']);
		$this->assertEquals(100, $input[Element::ATTRIBUTES]['cols']);
	}

}