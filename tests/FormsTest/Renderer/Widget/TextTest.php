<?php

namespace Sirius\FormsTest\Renderer\Widget;


use Sirius\Forms\Renderer\Widget\Text;

class TextTest extends \PHPUnit_Framework_TestCase {
	
	function setUp() {
		$this->input = new Text(array(
			'name' => 'username',
			'value' => 'siriusforms',
			'attrs' => array(
				'class' => 'not-valid'
			),
		));
	}

	function testFactoryMethod() {
		$input = Text::factory();
		$this->assertTrue($input instanceOf Text);
	}
	
	function testAttributes() {
		$this->assertEquals('siriusforms', $this->input->value());
		$this->assertEquals('siriusforms', $this->input->attr('value'));
		$this->assertEquals('username', $this->input->attr('name'));
		$this->assertTrue($this->input->hasClass('not-valid'));
	}
	
	function testRender() {
		$this->assertEquals('<input class="not-valid" name="username" value="siriusforms">', (string)$this->input);
	}
	
}