<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input;

class RadioTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Radio('option');

		$this->assertEquals('radio', $input[Input::WIDGET]);
	}

}