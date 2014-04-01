<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;

class RadioTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Radio('option');

		$this->assertEquals('radio', $input[Element::WIDGET]);
	}

}