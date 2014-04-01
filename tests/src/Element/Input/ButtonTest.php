<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;

class ButtonTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new Button('submit');

		$this->assertEquals('button', $input[Element::WIDGET]);
	}

}