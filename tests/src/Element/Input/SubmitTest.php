<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;

class SubmitTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Submit('submit');

		$this->assertEquals('button', $input[Element::WIDGET]);
		$this->assertEquals('submit', $input[Element::ATTRIBUTES]['type']);
	}

}