<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input;

class SubmitTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Submit('submit');

		$this->assertEquals('button', $input[Input::WIDGET]);
		$this->assertEquals('submit', $input[Input::ATTRIBUTES]['type']);
	}

}