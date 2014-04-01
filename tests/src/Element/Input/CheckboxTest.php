<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;

class CheckboxTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Checkbox('agree');

		$this->assertEquals('checkbox', $input[Element::WIDGET]);
	}

}