<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element;

class FileTest extends \PHPUnit_Framework_TestCase {

	function testDefaults() {
		$input = new File('option');

		$this->assertEquals('file', $input[Element::WIDGET]);
	}

}