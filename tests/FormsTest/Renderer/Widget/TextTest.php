<?php

namespace Sirius\FormsTest\Renderer\Widget;


use Sirius\Forms\Renderer\Widget\Text;

class TextTest extends \PHPUnit_Framework_TestCase {
	
	function setUp() {
		$this->input = new Text(array(
			'name' => 'username',
			'value' => 'siriusforms',
			'attrs' => array(
				'disabled' => true,
				'class' => 'not-valid'
			),
		));
	}

	function testFactoryMethod() {
		$input = Text::factory();
		$this->assertTrue($input instanceOf Text);
	}
	
	function testFactoryOfCustomElement() {
		$input = Text::factory(array(), 'em', false);
		$this->assertEquals('<em></em>', (string)$input);
	}
	
	function testAttributes() {
		$this->assertEquals('siriusforms', $this->input->value());
		$this->assertEquals('username', $this->input->attr('name'));
		$this->assertTrue($this->input->hasClass('not-valid'));
	}
	
	function testRender() {
		$this->assertEquals('<input class="not-valid" disabled name="username" value="siriusforms">', (string)$this->input);
	}
	
}