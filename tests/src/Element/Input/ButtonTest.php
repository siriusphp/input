<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input;

class ButtonTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Button('submit');

		$this->assertEquals('button', $input[Input::WIDGET]);
	}

}